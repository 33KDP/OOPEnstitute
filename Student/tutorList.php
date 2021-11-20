<?php
    session_start();
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";
    require_once "../bootstrap.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    $curStudent = Student::getInstance($_SESSION['user_id']);
    $enrolledTutors = $curStudent->getEnrolledTutors();
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tutors</title>
    </head>

    <body>
        <?php require_once "navbar.php"; ?>
        <div class="container">
            <h1>All Tutors</h1>

            <?php
                foreach ($enrolledTutors as $tutor) {
                    echo '
                        <a href="viewTutor.php?tid='.
                            $tutor->getTutorId()
                            .'" style="color: black; text-decoration: none;">'.
                            htmlentities($tutor->getFName()).' '.htmlentities($tutor->getLName())
                        .'</a> &emsp;
                        <div class="text-end" >
                            <a href="../User/message.php?receiver_id='.
                            $tutor->getId()
                            .'">Message</a> &emsp;
                            <a href="sendRequest.php?tutor_id='.
                            $tutor->getId()
                            .'">Send enrolment request</a>
                        </div>
                        <hr>
                    ';
                }
            ?>
            
        </div>
    </body>
</html>
