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
        <br>
        <h1>Conversations</h1>
        <br>
        <?php
            foreach ($usersWithConversations as $user) {
                $curTutor = Tutor::getInstance($user);
                echo '
                    <div class="card mx-auto rounded-3 border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="my-0"><a href="viewTutor.php?tid='.
                                $curTutor->getTutorId()
                                .'" style="text-decoration: none; color:black">'.
                                $curTutor->getFName().' '.$curTutor->getLName()
                            .'</a></h5> &emsp;
                            <div class="text-end" >
                                <a href="../User/message.php?receiver_id='.
                                    $curTutor->getId()
                                .'" class="btn btn-primary">Message</a> &emsp;
                            </div>
                        </div>
                    </div>
                ';
            }
        ?>
    </div>

<?php
    require_once "foot.php";
?>

