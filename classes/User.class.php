<?php

abstract class User
{
    private $userId;
    private $email;
    private $fName;
    private $lName;
    private $district;
    private $city;
    private $userTypeId;
    private $messageList;
    private $propic;
    // private $privateMessageList;
    // private $groupMessageList;
    private $rating;
    protected $dbCon;


    public function __construct($userId){
        $this->userId = $userId;
        $this->dbCon = DBConn::getInstance();
        $qry = $this->dbCon->getPDO()->prepare("SELECT * FROM `User` JOIN District ON `User`.district_id = District.id WHERE `User`.id=:uid");
        $qry->execute(array(':uid'=>$userId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->email=$row['email'];
        $this->fName=$row['first_name'];
        $this->lName=$row['last_name'];
        $this->district=$row['district'];
        $this->city=$row['city'];
        $this->userTypeId = $row['usertype_id'];
        $this->propic = $row['profile_picture'];

        // $this->privateMessageList = $this->getMessages($userId, 0);
        // $this->groupMessageList = $this->getMessages($userId, 1);



    }

    // private function getMessages($userId, $messageType)
    // {
    //     if ($messageType == 0)
    //     {
    //         $qry = $this->dbCon->getPDO()->prepare("SELECT * FROM `Message` WHERE (user_id = :senderId OR receiver = :receiverId) AND type = :messageType");
    //         $qry->execute(array(':senderId'=>$userId,
    //                             ':receiverId'=>$userId,
    //                             ':messageType'=>$messageType));
    //     }
    //     else
    //     {
    //         echo 'Hi';
    //     }
    //     echo 'Hi';
    // }

    public function getId()
    {
        return $this->userId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET email=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$email,
            ':uid'=>$this->userId));
        $this->email = $email;
    }

    public function getFName()
    {
        return $this->fName;
    }

    public function setFName($fName)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET first_name=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$fName,
            ':uid'=>$this->userId));
        $this->fName = $fName;
    }

    public function getLName()
    {
        return $this->lName;
    }


    public function setLName($lName)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET last_name=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$lName,
            ':uid'=>$this->userId));
        $this->lName = $lName;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function setDistrict($district)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET district_id= (SELECT id FROM district where district=:phld) WHERE id=:uiid");
        $qry->execute(array(
            ':phld'=>$district,
            ':uiid'=>$this->userId));
        $this->district = $district;
    }

    public function getCity()
    {
        return $this->city;
    }


    public function setCity($city)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET city=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$city,
            ':uid'=>$this->userId));
        $this->city = $city;
    }


    public function getUserTypeId()
    {
        return $this->userTypeId;
    }


    public function getProfilePic()
    {
        return $this->propic;
    }


    public function setProfilePic($fileName)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET profile_picture=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$fileName,
            ':uid'=>$this->userId));
        $this->propic = $fileName;
    }


    public function getRating()
    {
        return $this->rating;
    }


    public function setRating($rating)
    {
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET rating=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$rating,
            ':uid'=>$this->userId));
        $this->rating = $rating;
    }

    public function reset_password($old_pwd,$new_pwd,$confirm_pwd){
        if(empty($old_pwd) || empty($new_pwd) || empty($confirm_pwd)){
            $error_msg = "please fill all fields";
            set_session_fail($error_msg);
            if($this->userTypeId==1){
                header("location: ../../Student/profile.php");
            }else{
                header("location: ../../tutor/profile.php");
            }
            exit();
        }
        if($new_pwd !== $confirm_pwd){
            $error_msg = "Passwords are not matching";
            set_session_fail($error_msg);
            if($this->userTypeId==1){
                header("location: ../../Student/profile.php");
            }else{
                header("location: ../../tutor/profile.php");
            }
            exit();
        }

        $can_reset = false;
        $qry = $this->dbCon->getPDO()->prepare("SELECT `Authentication`.password  FROM `User` JOIN `Authentication` ON `User`.id=`Authentication`.user_id WHERE `User`.id=:uiid");
        $qry->execute(array(
            ':uiid'=>$this->userId
        ));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        if($row){
            if (password_verify($old_pwd, $row['password'])){
                $can_reset = true;
            }else{
                $can_reset = false;
                $error_msg = "Your entered password is wrong";
                set_session_fail($error_msg);
                if($this->userTypeId==1){
                    header("location: ../../Student/profile.php");
                }else{
                    header("location: ../../tutor/profile.php");
                }
                exit();
            }
        }else{
            $error_msg = "sql statement error";
            set_session_fail($error_msg);
            if($this->userTypeId==1){
                header("location: ../../Student/profile.php");
            }else{
                header("location: ../../tutor/profile.php");
            }
            exit(); 
        }

        if($can_reset){
            $hashedpwd = password_hash($new_pwd, PASSWORD_DEFAULT);

            $qry = $this->dbCon->getPDO()->prepare("UPDATE `authentication` SET password=:phld WHERE user_id=:uiid");
            $qry->execute(array(
                ':phld'=>$hashedpwd,
                ':uiid'=>$this->userId));

            $msg = "Password reset";
            set_session_success($msg);
            if($this->userTypeId==1){
                header("location: ../../Student/profile.php");
            }else{
                header("location: ../../tutor/profile.php");
            }
            exit(); 
        }

    }

    public function composeMessage($sender, $receiver, $messageBody, $messageType)
    {
        $message = new Message($sender, $receiver, $messageBody, $messageType, 0);
        $message->send($message);
    }

    public function readMessages($userId, $tutorId, $messageType)
    {
        $this->messageList = array();

        $stmt = Message::receive($userId, $tutorId, $messageType);

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($messageType == 0)
                $sender = htmlentities($row['user_id']);
            else
                $sender = htmlentities($row['user_id']);
                
            $receiver = htmlentities($row['receiver']);
            $messageBody = htmlentities($row['message']);
            $state = htmlentities($row['state']);
            $messageType = htmlentities($row['type']);
            
            $messageId = $row['id'];
            $qry = $this->dbCon->getPDO()->prepare("SELECT time FROM `Message` WHERE id=:messageId");
            $qry->execute(array(':messageId'=>$messageId));
            $row = $qry->fetch(PDO::FETCH_ASSOC);
            $time = $row['time'];
            
            $newMessage = new Message($sender, $receiver, $messageBody, $messageType, $state);
            $newMessage->setTime($time);

            array_push($this->messageList, $newMessage);

        }
        
        return $this->messageList;

    }


}