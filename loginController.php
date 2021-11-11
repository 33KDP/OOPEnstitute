<?php
    require_once('./classes/LogIn.class.php');

    $loginObj = new LogIn();
    echo "ok1\n";
    if (isset($_POST['Login'])){
        $loginObj->logInUser($_POST);
        echo "ok2\n";
    } else {
        header("location: index.php");
        echo "ok3\n";
    }
