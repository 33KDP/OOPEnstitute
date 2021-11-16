<?php
require_once "DBConn.class.php";
require_once "State.class.php";
abstract class Request
{
    private $senderId;
    private $receiverId;
    private $subjectId;
    private $message;
    private $state;
    private $type;

    /**
     * @param $senderId
     * @param $receiverId
     * @param $subjectId
     * @param $message
     * @param $state
     * @param $type
     */
    public function __construct($senderId, $receiverId, $subjectId, $message, $state, $type)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->subjectId = $subjectId;
        $this->message = $message;
        $this->state = $state;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }


    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

}