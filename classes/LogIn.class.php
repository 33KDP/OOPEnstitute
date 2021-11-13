<?php
require_once("Session.class.php");
require_once("DBConn.class.php");
require_once("Tutor.class.php");
require_once("Student.class.php");
session_start();

class LogIn
{
    private DBConn $dbCon;

    public function __construct(DBConn $db){
        $this->dbCon = $db;
    }

    private function validateForm($form){
        var_dump($form);
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
                if ($this->getUserType($form['uemail']) === 1){
                    $curUser = new Student($curUId);
                    $url = "../student/home.php";
                } else {
                    $curUser = new Tutor($curUId);
                    echo '1';
                    $url = "../tutor/home.php";
                }
                $curSession = Session::getInstance();
                $curSession->setUser($curUser);
                $curSession->setLoggedIn(true);
                $_SESSION['session'] = $curSession;
                echo '2';
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

