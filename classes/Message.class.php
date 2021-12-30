<?php
require_once "DBConn.class.php";
require_once "User.class.php";
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
        $this->senderFirstName = $sender->getFName();
        $this->senderLastName = $sender->getLName();
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
        $msgType = $this->messageType;
        if ($msgType == 0){
            $sql = "INSERT INTO message (user_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:user_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':user_id' => $this->sender->getId(),
                ':user_first_name' => $this->senderFirstName,
                ':user_last_name' => $this->senderLastName,
                ':receiver' => $this->receiver->getId(),
                ':message' => $this->messageBody,
                ':state' => $this->getStateValue(),
                ':type' => $msgType ));
        }
        else {
            $sql = "INSERT INTO message (group_id, user_first_name, user_last_name, receiver, message, state, type) VALUES (:group_id, :user_first_name, :user_last_name, :receiver, :message, :state, :type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':group_id' => $this->sender->getId(),
                ':user_first_name' => $this->senderFirstName,
                ':user_last_name' => $this->senderLastName,
                ':receiver' => $this->receiver->getId(),
                ':message' => $this->messageBody,
                ':state' => $this->getStateValue(),
                ':type' => $msgType ));
        }
    }

    public static function receiveMessages($user, $otherParty)
    {
        $userId = $user->getId();
        
        if ($otherParty instanceof User) {
            $receiverId = $otherParty->getId();
            $messageType = 0;
        }

        else {
            $receiverId = $otherParty->getId();
            $messageType = 1;
        }

        if ($messageType == 0) {
            $sql0 = "SELECT * FROM `Message` WHERE (((user_id = :userId AND receiver = :receiverId) OR (user_id = :receiverId AND receiver = :userId)) AND type = 0)";
            $sql1 = "UPDATE `Message` SET state = 1 WHERE (user_id = :receiverId AND receiver = :userId AND type = 0)";

            $stmt0 = self::$dbConn->getPDO()->prepare($sql0);
            $stmt0->execute(array(':userId'=>$userId,
                                ':receiverId'=>$receiverId));
        }
        else {
            $sql0 = "SELECT * FROM `Message` WHERE (receiver = :receiverId AND type = 1)";
            $sql1 = "UPDATE `Message` SET state = 1 WHERE (user_id != :userId AND receiver = :receiverId AND type = 1)"; 

            $stmt0 = self::$dbConn->getPDO()->prepare($sql0);
            $stmt0->execute(array(':receiverId'=>$receiverId));

        }

        $stmt1 = self::$dbConn->getPDO()->prepare($sql1);
        $stmt1->execute(array(':userId'=>$userId,
                            ':receiverId'=>$receiverId));

        return $stmt0;
    }
    
}

Message::init();