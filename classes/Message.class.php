<?php
require_once "DBConn.class.php";
require_once "MessageState.class.php";

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

        if ($state == 0)
            $this->state = Unread::getInstance();
        else if($state == 1)
            $this->state = Read::getInstance();

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

    public function getState()
    {
        return $this->state;
    }

    public function getStateValue() : int
    {
        return $this->state->getStateValue();
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function send()
    {
        $pdo = self::$dbConn->getPDO();
        $msgTtype = $this->messageType;
        if ($msgTtype == 0){
            $sql = "INSERT INTO message (user_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:user_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':user_id' => $this->sender,
                ':user_first_name' => $this->senderFirstName,
                ':user_last_name' => $this->senderLastName,
                ':receiver' => $this->receiver,
                ':message' => $this->messageBody,
                ':state' => $this->getStateValue(),
                ':type' => $this->messageType ));
        }
        else {
            $sql = "INSERT INTO message (group_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:group_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':group_id' => $this->sender,
                ':user_first_name' => $this->senderFirstName,
                ':user_last_name' => $this->senderLastName,
                ':receiver' => $this->receiver,
                ':message' => $this->messageBody,
                ':state' => $this->getStateValue(),
                ':type' => $this->messageType ));
        }
    }

    public static function receiveMessages($userId, $receiverId, $messageType)
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