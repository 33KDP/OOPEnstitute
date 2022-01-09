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
        <br>
        <h1>Enrolled Tutors</h1>
        <br>
        <?php
            foreach ($enrolledTutors as $tutor) {
                echo '
                    <div class="card mx-auto rounded-3 border-0 shadow my-3">
                        <div class="card-body">
                            <h5 class="my-0"><a href="viewTutor.php?tid='.
                                $tutor->getTutorId()
                                .'" style="text-decoration: none; color:black">'.
                                $tutor->getFName().' '.$tutor->getLName()
                            .'</a></h5> &emsp;
                            <div class="text-end" >
                                <a href="../User/message.php?receiver_id='.
                                    $tutor->getId()
                                .'" class="btn btn-primary">Message</a> &emsp;
                            </div>
                        </div>
                    </div>
                ';
            }
        ?>

    </div>
</body>

