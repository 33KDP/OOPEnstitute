<?php
    session_start();
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";


    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    $curStudent = Student::getInstance($_SESSION['user_id']);
    $enrolledTutors = $curStudent->getEnrolledTutors();

    require_once "../bootstrap.php";
    require_once "head.php";
    require_once "navbar.php"; ?>

<body>
    <div class="container">
        <h1>All Tutors</h1><br/>
                <?php
                    foreach ($enrolledTutors as $tutor) {
                        echo '
                            <a href="viewTutor.php?tid='.
                                $tutor->getTutorId()
                                .'" style="color: white; text-decoration: none;">'.
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
