<?php
    session_start();
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";
    require_once "../classes/Student.class.php";

    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    
    require_once "../bootstrap.php";
    require_once "head.php"; ?>

<body>
        <?php require_once "navbar.php";
            // if (!isset($_GET['sid'])){
            //     header("location: ../group_index.php");
            // }
            $tutor = Tutor::getInstance(Tutor::getUserId($_GET['tid']));
            echo'
                <div class="container p-5">
                    <div>Full Name : '.
                        $tutor->getFName().' '.$tutor->getLName()
                    .'</div>
                    <div>Email : '.
                        $tutor->getEmail()
                    .'</div>
                    <div>Description : '.
                        $tutor->getDescription()
                    .'</div>                  
                    <div>District : '.
                        $tutor->getDistrict()
                    .'</div>
                    <div>City : '.
                        $tutor->getCity()
                    .'</div><br>
                    <div>
                        <a class="btn btn-primary" href="../User/message.php?receiver_id='.$tutor->getId().'">Send Message</a>
                    </div><br>
            ';
            require_once "../User/reviewForm.php";
            echo '</div>';
        ?>
        
    </body>
</html>