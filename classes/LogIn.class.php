<?php
require_once("DBConn.class.php");
require_once("Tutor.class.php");
require_once("Student.class.php");
session_start();

class LogIn
{
    private $dbCon;

    public function __construct(){
        $this->dbCon = DBConn::getInstance();
    }

    private function validateForm($form){
        if(empty($form['uemail']) || empty($form['pwd'])){
            $reuslt = false;
        }else{
            $reuslt = true;
        }
        return $reuslt;
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
                if ($this->getUserType($form['uemail']) === 1){
                    $url = "../webapp/student/home.php";
                } else {
                    $url = "../webapp/tutor/home.php";
                }
                $_SESSION['user_id'] = $curUId;
                header("location: ".$url);
           } else {
               echo 'invalid cred';
               header("location: ../index.php");
           }
       } else {
           echo 'incomplete cred';
           header("location: ../index.php");
       }
    }
}

