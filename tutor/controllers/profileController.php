<?php

if(isset($_POST["set"])){
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
    update_tutor($_POST,$curTutor);
}elseif(isset($_POST["reset"])){
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
    reset_pwd($_POST,$curTutor);
}else{
    header("location: ../profile.php");
}

function update_tutor($_form,$tutor){
    $propic = $_form["profile_photo"];
    $fname = $_form["fname"];
    $lname = $_form["lname"];
    $distric = $_form["district"];
    $city = $_form["city"];
    $dis = $_form["description"];

    if(isset($_form["cbox"])){
        $availability = true;
    }else{
        $availability = false;
    }


    if($availability!=$tutor->isNotAvailable()){
        $tutor->setNotAvailable($availability)
    }
    if($fname!=$tutor->getFName()){
        $tutor->setFName($fname)
    }
    if($lname!=$tutor->getLName()){
        $tutor->setLName($lname)
    }
    if($distric!=$tutor->getDistrict()){
        $tutor->setDistrict($distric)
    }
    if($city!=$tutor->getCity()){
        $tutor->setCity($city)
    }
    if($dis!=$tutor->getDescription()){
        $tutor->setDescription($dis)
    }

    header("location: ../home.php");
}

function reset_pwd($_form,$user){
    $old_pwd = $_form["old_pwd"];
    $new_pwd = $_form["new_pwd"];
    $confirm_pwd = $_form["confirm_pwd"];
    $user->reset_password($old_pwd,$new_pwd,$confirm_pwd);
}