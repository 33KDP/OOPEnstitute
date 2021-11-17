<?php
    require_once "../classes/DBConn.class.php";
    require_once "../bootstrap.php";
    require_once "../classes/Student.class.php";
    require_once "../classes/tutor.class.php";
    session_start();

    $dbCon = DBConn::getInstance();
    $pdo = $dbCon->getPDO();

    $qry = $pdo->prepare("SELECT usertype_id FROM `User` WHERE id=:userId");
    $qry->execute(array(':userId'=>$_SESSION['user_id']));
    $row = $qry->fetch(PDO::FETCH_ASSOC);

    if ($row['usertype_id'] == 1)
        $curUser = Student::getInstance($_SESSION['user_id']);
    else
        $curUser = Tutor::getInstance($_SESSION['user_id']);

    if (isset($_GET['receiver_id']))
        $_SESSION['receiver_id'] = $_GET['receiver_id'];

    if (isset($_POST['send'])) {
        if (isset($_POST['message'])) {
            if(!empty(trim($_POST['message']))) 
                $curUser->composeMessage($_SESSION['user_id'], $_SESSION['receiver_id'], $_POST['message'], 0);
        }

        header("Location: message.php?receiver_id=".$_SESSION['receiver_id']."");
        return;       
    }

    $messages = $curUser->readMessages($_SESSION['user_id'], $_SESSION['receiver_id'], 0);
    $sql = "SELECT first_name, last_name FROM `User` WHERE id = :receiver_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':receiver_id' => $_SESSION['receiver_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($curUser->getUserTypeId() == 1)
        require_once "../Student/navbar.php";
    else
        require_once "../tutor/navbar.php";

?>

<!-- <style>
    <?php include 'styles.css'; ?>
</style> -->

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
    </head>

    <body>
        <div class="container">
            <?php
                if ($curUser->getUserTypeId() == 1)
                    echo ('<a href="../Student/tutorList.php">Back</a> &emsp;'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'<hr>');
                else
                    echo ('<a href="../tutor/conversations.php">Back</a> &emsp;'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'<hr>');

                foreach ($messages as $message) {
                    $sender = $message->getSender();
                    $receiver = $message->getReceiver();
                    $messageBody = $message->getMessageBody();
                    $time = $message->getTime();

                    if ($sender == $_SESSION['user_id'])
                    {
                        // echo '<div class="float-right">';
                        //     echo '<div class="card" style="width: 40rem;">';
                        //         echo '<div class="card-body text-start">';
                        //             echo $messageBody;
                        //             echo '<div class="text-end" >';
                        //                 echo (substr($time,0,-3));
                        //             echo '</div>';
                        //         echo '</div>';
                        //     echo '</div>';
                        // echo '</div>';

                        echo '<div class="text-end" >';
                        echo (htmlentities($messageBody));
                        echo '<br>';
                        echo (substr($time,0,-3));
                        echo '</div>';

                    }
                    else
                    {
                        // echo '<div class="card">';
                        //     echo '<div class="card-body text-start">';
                        //         echo $messageBody;
                        //         echo '<div class="text-end" >';
                        //             echo (substr($time,0,-3));
                        //         echo '</div>';
                        //     echo '</div>';
                        // echo '</div>';

                        echo '<div class="text-start" >';
                        echo (htmlentities($messageBody));
                        echo '<br>';
                        echo (substr($time,0,-3));
                        echo '</div>';
                    }
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
