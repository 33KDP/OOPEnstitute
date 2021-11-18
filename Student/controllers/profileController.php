<?php
require_once("../../includes/utils.php");
require_once "../../classes/Student.class.php";
require_once "../../classes/DBConn.class.php";
session_start();

if (isset($_POST["set"])) {
    $curStudent = Student::getInstance($_SESSION['user_id']);
    update_student($_POST, $curStudent);
} elseif (isset($_POST["reset"])) {
    $curStudent = Student::getInstance($_SESSION['user_id']);
    reset_pwd($_POST, $curStudent);
} else {
    header("location: ../profile.php");
}

function update_student($_form, $student)
{
    $propic = $_form["profile_photo"];
    $fname = $_form["fname"];
    $lname = $_form["lname"];
    $distric = $_form["district"];
    $city = $_form["city"];
    $grade = $_form["grade"];

    $isedit = false;
    $targetDir = "../../uploads/";
    $fileName = basename($_FILES["profile_photo"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if (!empty($_FILES["profile_photo"]["name"])) {
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"],  $targetFilePath)){
                // Insert image file name into database
                $student->setProfilePic($fileName);
                $statusMsg = "profile pic changed";
            }else{
                $statusMsg = "profile pic uploading fail";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    $isedit = true;
    }


    if ($fname != $student->getFName()) {
        $student->setFName($fname);
        $isedit = true;
    }
    if ($lname != $student->getLName()) {
        $student->setLName($lname);
        $isedit = true;
    }
    if ($distric != $student->getDistrict()) {
        $student->setDistrict($distric);
        $isedit = true;
    }
    if ($city != $student->getCity()) {
        $student->setCity($city);
        $isedit = true;
    }
    if ($grade != $student->getgrade()) {
        $student->setgrade($grade);
        $isedit = true;
    }
    if ($isedit) {
        $msg = "Updated successfully";
        set_session_success($msg);
        set_session_specail($statusMsg);
    } else {
        $msg = "no changes";
        set_session_success($msg);
    }
    header("location: ../profile.php");
}

function reset_pwd($_form, $user)
{
    $old_pwd = $_form["old_pwd"];
    $new_pwd = $_form["new_pwd"];
    $confirm_pwd = $_form["confirm_pwd"];
    $user->reset_password($old_pwd, $new_pwd, $confirm_pwd);
}