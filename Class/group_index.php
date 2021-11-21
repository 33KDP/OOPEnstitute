<?php
session_start();
require_once "../classes/DBConn.class.php";

if (empty($_GET['id'])) {
    header('location: individualClassList.php');

} else {

}


?>

<?php require_once "head.php"; ?>

<body class="sb-nav-fixed">

<?php require_once "navbar.php"; ?>

