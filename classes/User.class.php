<?php

abstract class User
{
    private int $userId;
    private string $email;
    private string $fName;
    private string $lName;
    private string $district;
    private string $city;
    private int $userTypeId;
    private $messageList;
    // private $privateMessageList;
    // private $groupMessageList;

    private $profilePic;
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
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `User` SET district=:phld WHERE id=:uid");
        $qry->execute(array(
            ':phld'=>$district,
            ':uid'=>$this->userId));
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
//        return $this->profilePic;
    }


    public function setProfilePic($profilePic)
    {
//        $this->profilePic = $profilePic;
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

    public function composeMessage($sender, $receiver, $messageBody, $messageType)
    {
        $message = new Message($sender, $receiver, $messageBody, $messageType, 0);
        $message->send($message);
    }

    public function readMessages($userId, $tutorId, $messageType)
    {
        $this->messageList = array();
        $sql0 = "SELECT * FROM `Message` WHERE (((user_id = :userId AND receiver = :tutorId) OR (user_id = :tutorId AND receiver = :userId)) AND type = :messageType)";
        $sql1 = "UPDATE `Message` SET state = 1 WHERE ((user_id = :tutorId AND receiver = :userId) AND type = :messageType)";

        $stmt = $this->dbCon->getPDO()->prepare($sql0);
        $stmt->execute(array(':userId'=>$userId,
                            ':tutorId'=>$tutorId,
                            ':messageType'=>$messageType));

        $stmt1 = $this->dbCon->getPDO()->prepare($sql1);
        $stmt1->execute(array(':userId'=>$userId,
                            ':tutorId'=>$tutorId,
                            ':messageType'=>$messageType));

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messageId = $row['id'];
            if ($messageType == 0)
                $sender = htmlentities($row['user_id']);

            $receiver = htmlentities($row['receiver']);
            $messageBody = htmlentities($row['message']);
            $state = htmlentities($row['state']);
            $messageType = htmlentities($row['type']);
            
            $newMessage = new Message($sender, $receiver, $messageBody, $messageType, $state);

            $qry = $this->dbCon->getPDO()->prepare("SELECT time FROM `Message` WHERE id=:messageId");
            $qry->execute(array(':messageId'=>$messageId));
            $row = $qry->fetch(PDO::FETCH_ASSOC);
            $time = $row['time'];
            $newMessage->setTime($time);

            array_push($this->messageList, $newMessage);

        }
        
        return $this->messageList;

    }


}