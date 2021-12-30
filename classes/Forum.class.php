<?php
require_once "DBConn.class.php";
require_once "Message.class.php";
require_once "Tutor.class.php";
require_once "Student.class.php";

class Forum
{
    private $forumId;
    protected $dbCon;

    public function __construct($id){
        $this->forumId = $id;
        $this->dbCon = DBConn::getInstance();
    }

    public function getId()
    {
        return $this->forumId;
    }

    public function composeMessage($sender, $receiver, $messageBody, $messageType)
    {
        $message = new Message($sender, $receiver, $messageBody, $messageType, 0);
        $message->send();
    }

    public function readMessages($curUser)
    {
        $this->messageList = array();

        $stmt = Message::receiveMessages($curUser, $this);

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {    
            $messageBody = htmlentities($row['message']);
            $state = htmlentities($row['state']);
            $time = $row['time'];
            
            $message = new Message($curUser, $this, $messageBody, 1, $state);
            $message->setTime($time);

            array_push($this->messageList, $message);

        }
        
    }

    public function getMessageList()
    {
        return $this->messageList;
    }

}