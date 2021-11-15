<?php
    require_once "../classes/Signup.class.php";

    
    if(isset($_POST["signup"])){
        $signupObj = new Signup();
        $signupObj->signup_user($_POST);
    }else{
        header("location: ../signup.php");
    }