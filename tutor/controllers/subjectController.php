<?php
    require_once "../classes/Subject.class.php";
    require_once "../classes/Tutor.class.php";
    session_start();
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);

    if (isset($_POST['Add'])){
        $subject = Subject::getInstance($_POST['subId']);
        $curTutor->setSubjects($subject);
        header("location: subjects.php");
    } else if (isset($_POST['Remove'])){
        $subject = Subject::getInstance($_POST['subId']);
        $curTutor->removeSubjects($subject);
        header("location: subjects.php");
    }else {
        header("location: subjects.php");
    }