<?php
    session_start();
    require_once('../../classes/JoinGroupRequest.class.php');
    if (!isset($_SESSION['user_id'])){
        header("location: ../index.php");
    }

    if (isset($_POST['Accept'])){
       $request = new JoinGroupRequest($_POST['reqId']);
       $request->accept($_POST);
    } else if (($_POST['Reject'])) {
        $request = new JoinGroupRequest($_POST['reqId']);
        $request->reject($_POST);
    }
    //var_dump($_POST);
    header("location: ../manage_group_request.php");