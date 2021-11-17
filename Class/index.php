<?php
    session_start();
    require_once "../classes/DBConn.class.php";

    if (empty($_GET['id'])) {
        header ('location: individualClassList.php' );

    } else {

    }


?>

<html>
<head>
    <?php require_once "../bootstrap.php"; ?>
    <?php require_once "../Student/head.php"; ?>
</head>

<body class="sb-nav-fixed">

    <?php require_once "navbar.php"; ?>

