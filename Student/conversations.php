<?php
    session_start();
    require_once "head.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../bootstrap.php";
    require_once "navbar.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    $curStudent = Student::getInstance($_SESSION['user_id']);
    $curStudent->setUsersWithConversations();
    $usersWithConversations = $curStudent->getUsersWithConversations();

?>

    <div class="container">
        <h1>Conversations</h1>
        <?php
            foreach ($usersWithConversations as $user) {
                $curTutor = Tutor::getInstance($user);
                echo '
                    <a href="viewTutor.php?tid='.
                        $curTutor->getTutorId()
                        .'" style="color: black; text-decoration: none;">'.
                        $curTutor->getFName().' '.$curTutor->getLName()
                    .'</a> &emsp;
                    <div class="text-end" >
                        <a href="../User/message.php?receiver_id='.
                            $curTutor->getId()
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

