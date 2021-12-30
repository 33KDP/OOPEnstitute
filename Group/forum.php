<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";
    require_once "../classes/forum.class.php";
    require_once "../bootstrap.php";

    if (isset($_SESSION['user_id']) and isset($_GET['fid'])){
        $user_id = $_SESSION['user_id'];
        $forum_id = $_GET['fid'];
        $forum = new Forum($forum_id);
        $usertype_id = User::getUserType($user_id);     
            
        if ($usertype_id == 1){
            $curUser = Student::getInstance($user_id);
            require_once "../Student/navbar.php";
        }
        else{
            $curUser = Tutor::getInstance($user_id);
            require_once "../tutor/navbar.php";
        }
    }
    else {
        header("location: ../index.php");
        return;
    }

    if (isset($_POST['send'])) {
        if (isset($_POST['message']) and !empty(trim($_POST['message']))) {
            $curUser->composeMessage($forum, $_POST['message'], 1);
            header("Location: forum.php?fid=".$forum_id."");
            return;
        }     
    }

    $forum->readMessages($curUser);
    $messages = $forum->getMessageList();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forum</title>
        <link rel="stylesheet" href="css/messageStyle.css">
    </head>

    <body>
        <div class="container py-5" >

            <?php
                echo '
                    <a href="groupDetails.php?id= '.$class->getGroupID().' &sid= '.$subject->getId().' &type=view" class="btn btn-primary">Back</a><h4 style="display:inline" class="mx-3" >'.
                        htmlentities($otherParty->getFName()).' '.htmlentities($otherParty->getLName())
                    .'</h4><hr class="m-1" ><br/>
                ';

                foreach ($messages as $message) {
                    $sender = $message->getSender();
                    $receiver = $message->getReceiver();
                    $messageBody = $message->getMessageBody();
                    $time = $message->getTime();

                    if ($sender == $user_id)
                        echo '
                            <div class="message right border border-primary mb-1 rounded w-25" >'.
                                htmlentities($messageBody)
                                .'<p class="mb-0 text-end">'.
                                substr($time,0,-3)
                                .'</p>
                            </div>
                        ';
                    else
                        echo '
                            <div class="message left border border-primary mb-1 rounded w-25" >'.
                                htmlentities($messageBody)
                                .'<p class="mb-0 text-end">'.
                                substr($time,0,-3)
                                .'</p>
                            </div>
                        ';
                }

            ?>
            <br>
            <form method="POST" class="row mb-3">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="message" id="message" placeholder="Message">
                </div>
                    <button type="submit" name="send" class="btn btn-primary col-sm-2">Send</button>
            </form>

        </div>
    </body>
</html>
