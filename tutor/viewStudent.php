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
                        <div>Full Name : '.
                            $student->getFName().' '.$student->getLName()
                        .'</div>
                        <div>Email : '.
                            $student->getEmail()
                        .'</div>
                        <div>Grade : '.
                            $student->getgrade()
                        .'</div>                  
                        <div>District : '.
                            $student->getDistrict()
                        .'</div>
                        <div>City : '.
                            $student->getCity()
                        .'</div><br>
                        <div>
                            <a class="btn btn-primary" href="../User/message.php?receiver_id='.$student->getId().'">Send Message</a>
                        </div><br>
                ';
                require_once "../User/reviewForm.php";
                echo '</div>';
            ?>
        </body>
    </html>