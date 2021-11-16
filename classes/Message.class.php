<?php
require_once "DBConn.class.php";

class Message
{
    private  $sender;
    private  $senderFirstName;
    private  $senderLastName;
    private  $receiver;
    private  $messageBody;
    private  $time;
    private  $state;
    private  $messageType;
    private static $dbConn;

    public function __construct($sender, $receiver, $messageBody, $messageType, $state){
        $this->sender = $sender;
        $qry = self::$dbConn->getPDO()->prepare("SELECT first_name, last_name FROM `User` WHERE id=:sender");
        $qry->execute(array(':sender'=>$sender));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->senderFirstName = $row['first_name'];
        $this->senderLastName = $row['last_name'];
        $this->receiver = $receiver;
        $this->messageBody = $messageBody;
        // date_default_timezone_set("Asia/Colombo");
        // $this->time = date("d.m.Y - h:i a");
        $this->state = $state;
        $this->messageType = $messageType;
    }

    public static function init(){
        self::$dbConn = DBConn::getInstance();
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getMessageBody()
    {
        return $this->messageBody;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function send($message)
    {
        $pdo = self::$dbConn->getPDO();
        $msgTtype = $message->messageType;
        if ($msgTtype == 0){
            $sql = "INSERT INTO message (user_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:user_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':user_id' => $message->sender,
                ':user_first_name' => $message->senderFirstName,
                ':user_last_name' => $message->senderLastName,
                ':receiver' => $message->receiver,
                ':message' => $message->messageBody,
                ':state' => $message->state,             
                ':type' => $message->messageType ));
        }
        else {
            $sql = "INSERT INTO message (group_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:group_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':group_id' => $message->sender,
                ':user_first_name' => $message->senderFirstName,
                ':user_last_name' => $message->senderLastName,
                ':receiver' => $message->receiver,
                ':message' => $message->messageBody,
                ':state' => $message->state,             
                ':type' => $message->messageType ));
        }
    }

    public static function receive($userId, $receiverId, $messageType)
    {
        $sql0 = "SELECT * FROM `Message` WHERE (((user_id = :userId AND receiver = :receiverId) OR (user_id = :receiverId AND receiver = :userId)) AND type = :messageType)";
        $sql1 = "UPDATE `Message` SET state = 1 WHERE ((user_id = :receiverId AND receiver = :userId) AND type = :messageType)";

        $stmt = self::$dbConn->getPDO()->prepare($sql0);
        $stmt->execute(array(':userId'=>$userId,
                            ':receiverId'=>$receiverId,
                            ':messageType'=>$messageType));

        $stmt1 = self::$dbConn->getPDO()->prepare($sql1);
        $stmt1->execute(array(':userId'=>$userId,
                            ':receiverId'=>$receiverId,
                            ':messageType'=>$messageType));
        
        return $stmt;
    }
    
}

Message::init();