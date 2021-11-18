<?php
    require_once("../../includes/utils.php");
    require_once "../../classes/Tutor.class.php";
    session_start();

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

        $isedit=false;
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
                    
                    $tutor->setProfilePic($fileName);
                    $statusMsg = "profile pic changed";
                }else{
                    $statusMsg = "profile pic uploading fail";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
        
        }
        if($availability!=$tutor->isNotAvailable()){
            $tutor->setNotAvailable($availability);
            $isedit=true;
        }
        if($fname!=$tutor->getFName()){
            $tutor->setFName($fname);
            $isedit=true;
        }
        if($lname!=$tutor->getLName()){
            $tutor->setLName($lname);
            $isedit=true;
        }
        if($distric!=$tutor->getDistrict()){
            $tutor->setDistrict($distric);
            $isedit=true;
        }
        if($city!=$tutor->getCity()){
            $tutor->setCity($city);
            $isedit=true;
        }
        if($dis!=$tutor->getDescription()){
            $tutor->setDescription($dis);
            $isedit=true;
        }
        if($isedit){
            $msg = "Updated successfully";
            set_session_success($msg);
            set_session_specail($statusMsg);
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