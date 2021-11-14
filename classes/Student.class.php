<?php
require_once("User.class.php");
require_once("Session.class.php");

class Student extends User
{
    private $grade;
    private $studentId;
    private static $instances;

    public function __contruct($userId)
    {
        parent::__contruct($userId);
        $qry = $this->dbCon->getPDO()->prepare("SELECT Student.grade, Student.id FROM `User` JOIN Student ON `User`.id = Student.user_id WHERE `User`.id=:uid");
        $qry->execute(array(':uid'=>$userId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->grade=$row['grade'];
        $this->studentId=$row['id'];
    }

    final public static function getInstance($userId)
    {
        if (!isset(self::$instances[$userId])) {
            self::$instances[$userId] = new Student($userId);
        }
        return self::$instances[$userId];
    }

    public function composeMessage($sender, $receiver, $messageBody, $messageType)
    {
        $message = new Message($sender, $receiver, $messageBody, $messageType);
        $message->send($message);
    }
    public function searchStudent() {

    }

    public function viewTutorDetails() {

    }

    public function contactTutor() {

    }

    public function enrollTutor() {

    }

    public function createGroup() {

    }

    public function searchGroup() {

    }

    public function joinGroup() {

    }

    public function viewGroupDetails() {

    }

    public function rateTutor() {

    }

    public function disenrollClass() {

    }


}