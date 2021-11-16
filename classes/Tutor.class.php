<?php
require_once "DBConn.class.php";
require_once "User.class.php";
require_once "Timeslot.class.php";
require_once "Subject.class.php";
require_once "EnrollRequest.class.php";

class Tutor extends User
{
    private $description;
    private $notAvailable;
    private $tutorId;
    private $timeSlots;
    private $subjects;
    private static $instances;

    private function __construct($userId)
    {
        parent::__construct($userId);
        $qry = $this->dbCon->getPDO()->prepare("SELECT Tutor.description, Tutor.id, Tutor.availability_flag FROM `User` JOIN tutor ON `User`.id = Tutor.user_id WHERE `User`.id=:uid");
        $qry->execute(array(':uid'=>$userId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->timeSlots = array();
        $this->subjects = array();
        $this->tutorId=$row['id'];
        $this->notAvailable=$row['availability_flag'];
        $this->description=$row['description'];
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
            ':tid'=>$this->tutorId));
        $this->description = $description;
    }

    public function isNotAvailable()
    {
        if($this->notAvailable){
            return true;
        }else{
            return false;
        }
    }

    public function setNotAvailable($notAvailable)
    {
        if ($notAvailable){
            $val = 1;
        } else {
            $val = 0;
        }
        $qry = $this->dbCon->getPDO()->prepare("UPDATE `Tutor` SET availability_flag=:phld WHERE id=:tid");
        /*
        $qry->bindParam(':tid',$this->tutorId , PDO::PARAM_INT);
        $qry->bindParam(':phld', $val);
        $qry->execute();
        */
        $qry->execute(array(
            ':phld'=>$val,
            ':tid'=>$this->tutorId));
    
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

    public function getSubjects(){
        $qry = $this->dbCon->getPDO()->prepare("SELECT Subject.id FROM Tutor_Subject JOIN
                                                                            Subject ON Tutor_Subject.subject_id=Subject.id WHERE Tutor_Subject.tutor_id=:tid");
        $qry->execute(array(':tid'=>$this->tutorId));
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($this->subjects, Subject::getInstance($row['id']));
        }
        return $this->subjects;
    }

    public function setSubjects($subject){
        $qry = $this->dbCon->getPDO()->prepare("INSERT INTO Tutor_Subject (tutor_id, subject_id) VALUES (:tid, :sid)");
        $qry->execute(array(
            ':tid'=>$this->tutorId,
            ':sid'=>$subject->getId()
        ));
        array_push($this->subjects, $subject);
    }

    public function removeSubjects($subject){
        $qry = $this->dbCon->getPDO()->prepare("DELETE FROM Tutor_Subject  WHERE tutor_id=:tid AND subject_id=:sid");
        $qry->execute(array(
            ':tid'=>$this->tutorId,
            ':sid'=>$subject->getId()
        ));
        if (($key = array_search($subject, $this->subjects)) !== false) {
            unset($this->subjects[$key]);
        }
    }

    public function getRequests(){
        $qry = $this->dbCon->getPDO()->prepare("SELECT Request.id FROM Tutor JOIN Request ON Tutor.id=request.tutor_id WHERE Tutor.id=:tid");
        $qry->execute(array(
            ':tid'=>$this->tutorId
        ));
        $requests = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($requests, new EnrollRequest($row['id']));
        }
        return $requests;
    }
}