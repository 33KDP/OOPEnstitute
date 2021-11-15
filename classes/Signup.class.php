<?php
require_once("DBConn.class.php");
session_start();

class Signup
{
    private $dbCon;

    public function __construct(){
        $this->dbCon = DBConn::getInstance();
    }

    private function emptyInputSignup($fname,$lname,$email,$pwd,$pwdrepeat,$user_type,$grade,$distric,$city){
        if( empty($fname) || empty($lname) || empty($email)  || empty($pwd) || empty($pwdrepeat) || empty($user_type) || empty($distric) || empty($city)){
            $reuslt = true;
        }else{
            if($user_type=="student"){
                if(empty($grade)){
                    $reuslt = true;
                }else{
                    $reuslt = false;
                }
            }else{
                $reuslt = false;
            }    
        }
        return $reuslt;
    }
    
    private function invalidUid($username){
        if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
            $reuslt = true;
        }else{
            $reuslt = false;
        }
        return $reuslt;
    }
    
    private function invalidEmail($email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $reuslt = true;
        }else{
            $reuslt = false;
        }
        return $reuslt;
    }
    
    private function pwdnotMatch($pwd,$pwdrepeat){
        if($pwd !== $pwdrepeat){
            $reuslt = true;
        }else{
            $reuslt = false;
        }
        return $reuslt;
    }
    
    private function UidExists($conn,$email){
    
        $sql="SELECT * FROM user WHERE email = :ue";
        $stmt = $conn->prepare($sql);
    
        $stmt -> execute(array(
            ':ue' => $email
        ));
        $row = $stmt->fetch(pdo::FETCH_ASSOC);
    
        if($row){
            $usid = $row["id"];
    
            $sql2="SELECT * FROM `authentication` WHERE `user_id` = :userid";
            $stmt2 = $conn->prepare($sql2);
        
            $stmt2 -> execute(array(
                ':userid' => $usid
            ));
            $row2 = $stmt2->fetch(pdo::FETCH_ASSOC);
        
            $row["password"] = $row2["password"];
            return $row;
        }else{
            $reuslt = false;
            return $reuslt;
        }
    }
    
    private function createUser($conn,$fname,$lname,$email,$pwd,$user_type,$grade,$distric,$city){
        if($user_type=="student"){
            $sql1="INSERT INTO user(usertype_id,email,first_name,last_name,district,city) VALUES(:utype,:uemail,:fname,:lname,:distric,:city)";
            $stmt1  = $conn->prepare($sql1);
        
            $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
        
            $stmt1->execute(array(
                ':utype' => 1,
                ':uemail' => $email,
                ':fname' => $fname,
                ':lname' => $lname,
                ':distric' => $distric,
                ':city' => $city)
                );
    
            $profile_id = $conn->lastInsertId();
    
            $sql2="INSERT INTO `authentication`(`user_id`,`password`) VALUES(:uida,:upassword)";
            $stmt2  = $conn->prepare($sql2);
            $stmt2->execute(array(
                ':uida' => $profile_id,
                ':upassword' => $hashedpwd)
                );
    
            $sql3="INSERT INTO student(`user_id`,grade) VALUES(:uids,:sgrade)";
            $stmt3  = $conn->prepare($sql3);
            $stmt3->execute(array(
                ':uids' => $profile_id,
                ':sgrade' => $grade)
                );
    
        }else{
            $sql1="INSERT INTO user(usertype_id,email,first_name,last_name,district,city) VALUES(:utype,:uemail,:fname,:lname,:distric,:city)";
            $stmt1  = $conn->prepare($sql1);
        
            $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
        
            $stmt1->execute(array(
                ':utype' => 2,
                ':uemail' => $email,
                ':fname' => $fname,
                ':lname' => $lname,
                ':distric' => $distric,
                ':city' => $city)
                );
    
            $profile_id = $conn->lastInsertId();
    
            $sql2="INSERT INTO `authentication`(`user_id`,`password`) VALUES(:uida,:upassword)";
            $stmt2  = $conn->prepare($sql2);
            $stmt2->execute(array(
                ':uida' => $profile_id,
                ':upassword' => $hashedpwd)
                );
    
            $sql3="INSERT INTO tutor(`user_id`) VALUES(:uids)";
            $stmt3  = $conn->prepare($sql3);
            $stmt3->execute(array(
                ':uids' => $profile_id)
                );
                
        }
    
    
        $profile_id = $conn->lastInsertId();
        if($profile_id){
            header("location: ../signup.php?error=none");
        }else{
            header("location: ../signup.php?error=stmtfailed");
        }
        
    }

    public function signup_user($form){

        $fname = $form["fname"];
        $lname = $form["lname"];
        $grade = $form["grade"];
        $distric = $form["district"];
        $city = $form["city"];
        $email = $form["email"];
        $pwd = $form["pwd"];
        $pwdrepeat = $form["pwdrepeat"];
        $user_type = $form["usertype"];

        $conn = $this->dbCon->getPDO();
        if($this->emptyInputSignup($fname,$fname,$email,$pwd,$pwdrepeat,$user_type,$grade,$distric,$city) !== false){
            header("location: ../signup.php?error=emptyinput");
            exit();
        }
        if($this->invalidEmail($email) !== false){
            header("location: ../signup.php?error=invalidemail");
            exit();
        }
        if($this->pwdnotMatch($pwd,$pwdrepeat) !== false){
            header("location: ../signup.php?error=passwordsdontmatch");
            exit();
        }
        if($this->UidExists($conn,$email) !== false){
            header("location: ../signup.php?error=usernametaken");
            exit();
        }
        $this->createUser($conn,$fname,$lname,$email,$pwd,$user_type,$grade,$distric,$city);
        
    }


}