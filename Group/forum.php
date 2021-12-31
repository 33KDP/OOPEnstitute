<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";
    require_once "../classes/StudentGroup.class.php";
    require_once "../bootstrap.php";

    if (isset($_SESSION['user_id']) and isset($_GET['id'])){
        $user_id = $_SESSION['user_id'];
        $curGroup = new StudentGroup($_GET['id']);
        $forum = $curGroup->getForum();
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
            header("Location: forum.php?id=".$curGroup->getGroupId()."");
            return;
        }     
    }

    $forum->readMessages($curUser);
    $messages = $forum->getMessageList();

    require_once "head.php"
?>

    <div class="container py-3 px-0" >

        <?php
            echo '
                <a href="groupDetails.php?id= '.$curGroup->getGroupID().' &sid= '.$curGroup->getSubjectId().' &type=view" class="btn btn-primary">Back</a><h4 style="display:inline" class="mx-3" >'.
                    "Forum - ".htmlentities($curGroup->getName())
                .'</h4><hr class="m-1" ><br/>
            ';

            echo '<div id = "scrollDiv" style = "height: 442px; width: auto; overflow: auto;">';
                foreach ($messages as $message) {
                    $sender = $message->getSender();
                    $sender_id = $sender->getId();
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
                            <div class="message left border border-primary mb-1 rounded w-25" >
                                <h6 class="mb-0 text-start">'.
                                htmlentities($sender->getFName()).' '.htmlentities($sender->getLName())
                                .'</h6><hr class="my-0" >'.
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
