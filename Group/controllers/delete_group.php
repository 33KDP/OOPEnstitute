<?php

session_start();
if (!isset($_SESSION['user_id'])){
    header("location: ../index.php");
}

if (isset($_POST['Delete'])) {
    StudentGroup::deletegroup($_POST['groupid']);
}
