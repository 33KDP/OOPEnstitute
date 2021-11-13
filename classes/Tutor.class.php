<?php
require_once "DBConn.class.php";
require_once "User.class.php";
require_once "Timeslot.class.php";

class Tutor extends User
{
    private  $description;
    private  $notAvailable;
    private  $tutorId;
    private  $timeSlots;
    private static $instances;

    private function __construct($userId)
    {
        parent::__contruct($userId);
        $qry = $this->dbCon->getPDO()->prepare("SELECT Tutor.description, Tutor.id, Tutor.availability_flag FROM `User` JOIN tutor ON `User`.id = Tutor.user_id WHERE `User`.id=:uid");
        $qry->execute(array(':uid'=>$userId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->timeSlots = array();
        $this->tutorId=$row['id'];
        $this->notAvailable=$row['availability_flag'];
    }

    final public static function getInstance($userId)
    {
        if (!isset(self::$instances[$userId])) {
            self::$instances[$userId] = new Tutor($userId);
        }
        return self::$instances[$userId];
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {

        $qry = $this->dbCon->getPDO()->prepare("UPDATE `Tutor` SET description=:phld WHERE id=:tid");
        $qry->execute(array(
            ':phld'=>$description,
            ':uid'=>$this->tutorId));
        $this->description = $description;
    }

    public function isNotAvailable()
    {
        return $this->notAvailable;
    }

    public function setNotAvailable($notAvailable)
    {
        if ($notAvailable){
            $val = 1;
        } else {
            $val = 0;
        }
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `Tutor` SET availability_flag=:phld WHERE id=:tid");
        $qry->execute(array(
            ':phld'=>$val,
            ':uid'=>$this->tutorId));
        $this->notAvailable = $notAvailable;
    }

    public function getTutorId()
    {
        return $this->tutorId;
    }

    public function getTimeSlots(){
        $qry = $this->dbCon->getPDO()->prepare("SELECT id FROM TimeSlot WHERE tutor_id=:tid");
        $qry->execute(array(':tid'=>$this->tutorId));
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($this->timeSlots, Timeslot::getInstance($row['id']));
        }
        return $this->timeSlots;
    }



}