<?php
    session_start();
    require_once('../../classes/EnrollRequest.class.php');
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    if (isset($_POST['Accept'])){
       $request = new EnrollRequest($_POST['reqId']);
       $request->accept();
    } else if (($_POST['Reject'])) {
        $request = new EnrollRequest($_POST['reqId']);
        $request->reject();
    } else {
        header("location: ../timeslots.php");
    }