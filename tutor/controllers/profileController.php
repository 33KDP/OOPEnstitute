<?php

if(isset($_POST["set"])){
    $curTutor=  Tutor::getInstance($_SESSION['user_id']);
    update_tutor($_POST,$curTutor);
}else{
    header("location: ../signup.php");
}

function update_tutor($_form,$tutor){
    $fname = $_form["fname"];
    $fname = $_form["lname"];
    $fname = $_form["district"];
    $fname = $_form["city"];
    $fname = $_form["description"];
    $fname = $_form["fname"];
}