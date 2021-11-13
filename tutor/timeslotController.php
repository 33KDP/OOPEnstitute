<?php
    require_once('../classes/Timeslot.class.php');

    if (isset($_POST['Add'])){
        Timeslot::addTimeslot($_POST);
    } else if (($_POST['Save'])) {
        $timeSlot = Timeslot::getInstance($_POST['timeid']);
        $timeSlot->editTimeSlot($_POST);
    }else if (isset($_POST['Delete'])) {
        Timeslot::deleteTimeSlot($_POST['timeid']);
    } else {
        header("location: timeslots.php");
    }