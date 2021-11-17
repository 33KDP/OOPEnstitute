<?php
    require_once("../../includes/utils.php");
    require_once "../../classes/Student.class.php";
    session_start();

    if(isset($_POST["set"])){
        $curStudent=  Student::getInstance($_SESSION['user_id']);
        update_tutor($_POST,$curStudent);
    }elseif(isset($_POST["reset"])){
        $curStudent=  Student::getInstance($_SESSION['user_id']);
        reset_pwd($_POST,$curStudent);
    }else{
        header("location: ../profile.php");
    }

    function update_tutor($_form,$student){
        $propic = $_form["profile_photo"];
        $fname = $_form["fname"];
        $lname = $_form["lname"];
        $distric = $_form["district"];
        $city = $_form["city"];
        $grade = $_form["grade"];
        $stid = $_form["studentid"];

        $isedit=false;

        if($propic){
            $student->setProfilePic($propic);
            $isedit=true;
        }
        if($fname!=$student->getFName()){
            $student->setFName($fname);
            $isedit=true;
        }
        if($lname!=$student->getLName()){
            $student->setLName($lname);
            $isedit=true;
        }
        if($distric!=$student->getDistrict()){
            $student->setDistrict($distric);
            $isedit=true;
        }
        if($city!=$student->getCity()){
            $student->setCity($city);
            $isedit=true;
        }
        if($grade!=$student->getgrade()){
            $student->setgrade($grade);
            $isedit=true;
        }
        if($isedit){
            $msg = "Updated successfully";
            set_session_success($msg);
        }else{
            $msg = "no changes";
            set_session_success($msg);
        }
        header("location: ../profile.php");
    }

    function reset_pwd($_form,$user){
        $old_pwd = $_form["old_pwd"];
        $new_pwd = $_form["new_pwd"];
        $confirm_pwd = $_form["confirm_pwd"];
        $user->reset_password($old_pwd,$new_pwd,$confirm_pwd);
    }