<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";
    require_once "../bootstrap.php";

    if (isset($_SESSION['user_id']) and isset($_GET['receiver_id']) and ($_SESSION['user_id'] != $_GET['receiver_id'])){
        $user_id = $_SESSION['user_id'];
        $receiver_id = $_GET['receiver_id'];
        $usertype_id = User::getUserType($user_id);     
            
        if ($usertype_id == 1){
            $curUser = Student::getInstance($user_id);
            $otherParty = Tutor::getInstance($receiver_id);
            require_once "../Student/navbar.php";
        }
        else{
            $curUser = Tutor::getInstance($user_id);
            $otherParty = Student::getInstance($receiver_id);
            require_once "../tutor/navbar.php";
        }
    }
    else {
        header("location: ../index.php");
        return;
    }

    if (isset($_POST['send'])) {
        if (isset($_POST['message']) and !empty(trim($_POST['message']))) {
            $curUser->composeMessage($otherParty, $_POST['message'], 0);
            header("Location: message.php?receiver_id=".$receiver_id."");
            return;
        }     
    }

    $curUser->readMessages($otherParty);
    $messages = $curUser->getMessageList();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>E-nstitute</title>
        <link rel="stylesheet" href="css/messageStyle.css">
    </head>

    <body>
        <div class="container py-3 px-0" >

            <?php
                if ($usertype_id == 1)
                    echo '
                        <a href="../Student/conversations.php" class="btn btn-primary">Back</a><h4 style="display:inline" class="mx-3" >'.
                            htmlentities($otherParty->getFName()).' '.htmlentities($otherParty->getLName())
                        .'</h4><hr class="m-1" ><br/>
                    ';
                else
                    echo '
                        <a href="../tutor/conversations.php" class="btn btn-primary">Back</a><h4 style="display:inline" class="mx-3" >'.
                            htmlentities($otherParty->getFName()).' '.htmlentities($otherParty->getLName())
                        .'</h4><hr class="m-1" ><br/>
                    ';

                echo '<div id = "scrollDiv" style = "height: 442px; width: auto; overflow: auto;">';
                    foreach ($messages as $message) {
                        $sender_id = $message->getSender()->getId();
                        $messageBody = $message->getMessageBody();
                        $time = $message->getTime();

                        if ($sender_id == $user_id)
                            echo '
                                <div class="message right border border-primary mb-1 rounded w-25" >'.
                                    htmlentities($messageBody)
                                    .'<p class="mb-0 text-end date">'.
                                    substr($time,0,-3)
                                    .'</p>
                                </div>
                            ';
                        else
                            echo '
                                <div class="message left border border-primary mb-1 rounded w-25" >'.
                                    htmlentities($messageBody)
                                    .'<p class="mb-0 text-end date">'.
                                    substr($time,0,-3)
                                    .'</p>
                                </div>
                            ';
                    }
                echo '</div>';

            ?>
            <br>
            <form method="POST" style="display:flex">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="message" id="message" placeholder="Message">
                </div>
                    <button type="submit" name="send" class="btn btn-primary col-sm-2">Send</button>
            </form>

        </div>
    </body>
</html>

<script type="text/javascript">
    var scrollDiv = document.getElementById("scrollDiv");
    scrollDiv.scrollTop = scrollDiv.scrollHeight;
</script>
