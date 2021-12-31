<?php
require_once "Message.class.php";
require_once "User.class.php";
require_once "Tutor.class.php";
require_once "Student.class.php";

class Forum
{
    private $forumId;

    public function __construct($id){
        $this->forumId = $id;
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
            $senderId = htmlentities($row['user_id']); 
            $messageBody = htmlentities($row['message']);
            $state = htmlentities($row['state']);
            $time = $row['time'];

            if (User::getUserType($senderId) == 1)
                $sender = Student::getInstance($senderId);
            else
                $sender = Tutor::getInstance($senderId);
            
            $message = new Message($sender, $this, $messageBody, 1, $state);
            $message->setTime($time);

            array_push($this->messageList, $message);
        }
        
    }

    public function getMessageList()
    {
        return $this->messageList;
    }

}