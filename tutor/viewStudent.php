<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
?>

    <html>
        <head>
            <?php require_once "../bootstrap.php"; ?>
            <?php require_once "head.php"; ?>
        </head>
        <body>
            <?php require_once "navbar.php";
                if (!isset($_GET['sid'])){
                    header("location: ../index.php");
                }
                $student = Student::getInstance(Student::getUserId($_GET['sid']));
                echo'
                    <div class="container p-5">
                        <div>'.
                            $student->getFName().' '.$student->getLName()
                        .'</div>
                        <div>'.
                            $student->getDistrict()
                        .'</div>
                        <div>
                            <button class="btn btn-primary">Send Message</button>
                        </div>
                    </div>
                ';
            ?>
        </body>
    </html>