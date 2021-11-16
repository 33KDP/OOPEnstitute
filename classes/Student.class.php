<?php
require_once "DBConn.class.php";
require_once "User.class.php";
require_once("Session.class.php");
require_once("Message.class.php");

class Student extends User
{
    private $grade;
    private $studentId;
    private static $instances;

    public function __construct($userId)
    {
        parent::__construct($userId);
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

    public function getSubjects() {
//        $qry = $this->dbCon->getPDO()->prepare("SELECT Subject.id FROM Subject WHERE Subject.id = :sid");
//        $qry->execute(array(':sid'=>$this->subjectID));
//        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
//            array_push($this->subjects, Subject::getInstance($row['id']));
//        }
//        return $this->subjects;
    }

    public function getStudentID() {
        return $this->studentId;
    }

}