<?php
    //session_start();
    require_once "../classes/Session.class.php";
    require_once "../classes/DBConn.class.php";
    require_once "../classes/Tutor.class.php";

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
        <?php require_once "navbar.php"; ?>

    </body>
</html>
