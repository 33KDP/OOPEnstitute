<?php
    require_once('../../classes/Timeslot.class.php');
    session_start();
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    if (isset($_POST['Add'])){
        Timeslot::addTimeslot($_POST);
        $_SESSION['success'] = "Timeslot added";
    } else if (($_POST['Save'])) {
        $timeSlot = Timeslot::getInstance($_POST['timeid']);
        $timeSlot->editTimeSlot($_POST);
        $_SESSION['success'] = "Changes saved";
    }else if (isset($_POST['Delete'])) {
        Timeslot::deleteTimeSlot($_POST['timeid']);
    } else {
        header("location: ../timeslots.php");
    }