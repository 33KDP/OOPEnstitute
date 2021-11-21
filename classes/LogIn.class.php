<?php
require_once("DBConn.class.php");
require_once("Tutor.class.php");
require_once("Student.class.php");
require_once("../includes/utils.php");
session_start();

class LogIn
{
    private $dbCon;

    public function __construct(){
        $this->dbCon = DBConn::getInstance();
    }

    private function validateForm($form){
        if(empty($form['uemail']) || empty($form['pwd'])){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function validateUser($uemail, $pwd){
        $qry = $this->dbCon->getPDO()->prepare("SELECT `User`.id, `Authentication`.password  FROM `User` JOIN `Authentication` ON `User`.id=`Authentication`.user_id WHERE `User`.email=:uemail");
        $qry->execute(array(
            ':uemail'=>$uemail
        ));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        if($row){
            if (password_verify($pwd, $row['password'])){
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function getUserType($uemail){
        $qry = $this->dbCon->getPDO()->prepare("SELECT usertype_id  FROM `User` WHERE email=:uemail");
        $qry->execute(array(
            ':uemail'=>$uemail
        ));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        return $row['usertype_id'];
    }

    public function logInUser($form){
       if ($this->validateForm($form)){
           if ($curUId = $this->validateUser($form['uemail'], $form['pwd'])){
               //var_dump($this->getUserType($form['uemail']));
                if ($this->getUserType($form['uemail']) == 1){
                    $url = "../Student/index.php";
                } else {
                    $url = "../tutor/home.php";
                }
                $_SESSION['user_id'] = $curUId;
                header("location: ".$url);
           } else {
                $error_msg = "Incorrect username or password";
                set_session_fail($error_msg);
                set_try_login("tried to login");
                header("location: ../index.php");
           }
       } else {
            $error_msg = "please fill all fields";
            set_session_fail($error_msg);
            set_try_login("tried to login");
            header("location: ../index.php");
       }
    }
}

