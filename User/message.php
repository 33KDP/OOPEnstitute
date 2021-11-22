<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";
    require_once "../bootstrap.php";

    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $usertype_id = User::getUserType($user_id);

        if ($usertype_id == 1)
            $curUser = Student::getInstance($user_id);
        else
            $curUser = Tutor::getInstance($user_id);

        if(isset($_GET['receiver_id']) or isset($_GET['group_id'])){
            if(isset($_GET['receiver_id'])){
                if($user_id != $_GET['receiver_id'])
                    $receiver_id = $_GET['receiver_id'];
                else
                    header("location: ../index.php");
            }
            else
                $group_id = $_GET['receiver_id'];
        }
        else
            header("location: ../index.php");
    }
    else
        header("location: ../index.php");

    if (isset($_POST['send'])) {
        if (isset($_POST['message'])) {
            if(!empty(trim($_POST['message']))) {
                if (isset($receiver_id)){
                    $curUser->composeMessage($user_id, $receiver_id, $_POST['message'], 0);
                    header("Location: message.php?receiver_id=".$receiver_id."");
                    return; 
                }
                else{
                    $curUser->composeMessage($user_id, $group_id, $_POST['message'], 1);
                    header("Location: message.php?receiver_id=".$group_id."");
                    return; 
                }    
            }       
        }     
    }

    $curUser->readMessages($user_id, $receiver_id, 0);
    $messages = $curUser->getMessageList();

    if ($usertype_id == 1){
        $receiver = Tutor::getInstance($receiver_id);
        require_once "../Student/navbar.php";
    }
    else{
        $receiver = Student::getInstance($receiver_id);
        require_once "../tutor/navbar.php";
    }

?>

<!-- <script type="text/javascript">
    const tx = document.getElementsByTagName("textarea");
    for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
        tx[i].addEventListener("input", OnInput, false);
    }

    function OnInput() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
    }
</script> -->

<!DOCTYPE html>
<html>
    <head>
        <title>Message</title>
        <link rel="stylesheet" href="css/messageStyle.css">
    </head>

    <body>
        <div class="container py-5" >

            <?php
                if ($usertype_id == 1)
                    echo '
                        <a href="../Student/conversations.php" class="btn btn-primary">Back</a><h4  style="display:inline; float: right "  >'.
                            htmlentities($receiver->getFName()).' '.htmlentities($receiver->getLName())
                        .'</h4><hr><br/>
                    ';
                else
                    echo '
                        <a href="../tutor/conversations.php" class="btn btn-secondary">Back</a> &emsp;'.
                            htmlentities($receiver->getFName()).' '.htmlentities($receiver->getLName())
                        .'<hr>
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
