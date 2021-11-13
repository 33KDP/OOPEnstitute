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
    private static $instances;

    public function __construct($sender, $receiver, $messageBody, $messageType){
        $this->sender = $sender;
        $qry = self::$dbConn->getPDO()->prepare("SELECT first_name, last_name FROM `User` WHERE id=:sender");
        $qry->execute(array(':sender'=>$sender));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->senderFirstName = $row['first_name'];
        $this->senderLastName = $row['last_name'];
        $this->receiver = $receiver;
        $this->messageBody = $messageBody;
        date_default_timezone_set("Asia/Colombo");
        $this->time = date("d.m.Y - h:i a");
        $this->state = 0;
        $this->messageType = $messageType;
    }

    public static function init(){
        self::$dbConn = DBConn::getInstance();
        self::$instances = array();
    }

    final public static function getInstance($timeslotId)
    {
        if (!isset(self::$instances[$timeslotId])) {
            self::$instances[$timeslotId] = new Timeslot( $timeslotId);
        }
        return self::$instances[$timeslotId];
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
                ':user_id' => $message->sender,
                ':user_first_name' => $message->senderFirstName,
                ':user_last_name' => $message->senderLastName,
                ':receiver' => $message->receiver,
                ':message' => $message->messageBody,
                ':state' => $message->state,             
                ':type' => $message->messageType ));
        }
    }
    
}

Message::init();