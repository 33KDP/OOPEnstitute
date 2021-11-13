<?php
    require_once "../classes/DBConn.class.php";
    require_once "../bootstrap.php";
    require_once "../classes/Student.class.php";
    $dbCon = DBConn::getInstance();
    $pdo = $dbCon->getPDO();

    $curStudent = Student::getInstance($_SESSION['user_id']);

    if (isset($_GET['tutor_id']))
        $_SESSION['tutor_id'] = $_GET['tutor_id'];

    if (isset($_POST['send'])) {
        if (isset($_POST['message'])) {
            if(!empty(trim($_POST['message']))) {
                $curStudent->composeMessage($_SESSION['user_id'], $_SESSION['tutor_id'], $_POST['message'], 0);
                echo "Message sent";         
            }
        }
        header("Location: message.php?tutor_id=".$_SESSION['tutor_id']."");
        return;       
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
    </head>

    <body>
        <div class="container">
            <?php
                $sql = "SELECT first_name, last_name FROM `User` WHERE id = :tutor_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':tutor_id' => $_SESSION['tutor_id']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo ('<a href="../Student/tutorList.php">Back</a> &emsp;'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']));

                echo '<div class="text-end">';
                echo '<a href="logout.php" class="text-end">Logout</a><br>';
                echo '</div><hr>';

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo (htmlentities($row['first_name']).' '.htmlentities($row['last_name']));
                    echo '<div class="text-end" >';
                    echo ('<a href="../tutor/viewDetails.php?tutor_id='.$row['id'].'">View details</a> &emsp;');
                    echo ('<a href="../User/message.php?tutor_id='.$row['id'].'">Message</a> &emsp;');
                    echo ('<a href="sendRequest.php?tutor_id='.$row['id'].'">Send enrolment request</a>');
                    echo '</div>';
                    echo '<hr>';
                }

            ?>

            <form method="POST" class="row mb-3">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="message" id="message" placeholder="Message">
                </div>
                    <button type="submit" name="send" class="btn btn-primary col-sm-2">Send</button>
            </form>

        </div>
    </body>
</html>
