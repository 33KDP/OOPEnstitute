<?php
    session_start();
    unset($_SESSION['receiver_id']);
    require_once "head.php";
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../bootstrap.php";
    require_once "navbar.php";
    $pdo = DBConn::getInstance()->getPDO();

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    $curTutor = Tutor::getInstance($_SESSION['user_id']);
    $curTutor->setUsersWithConversations();
    $usersWithConversations = $curTutor->getUsersWithConversations();

?>

    <div class="container">
        <h1>Conversations</h1>
        <?php
            foreach ($usersWithConversations as $user) {
                $curStudent = Student::getInstance($user);
                echo '
                    <a href="viewStudent.php?sid='.
                        $curStudent->getstudentId()
                        .'" style="color: black; text-decoration: none;">'.
                        $curStudent->getFName().' '.$curStudent->getLName()
                    .'</a> &emsp;
                    <div class="text-end" >
                        <a href="../User/message.php?receiver_id='.
                            $curStudent->getId()
                        .'">Message</a> &emsp;
                    </div>
                    <hr>
                ';
            }
        ?>
    </div>

<?php
    require_once "foot.php";
?>

