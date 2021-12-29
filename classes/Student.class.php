<?php
require_once("User.class.php");
require_once("StudentGroup.class.php");

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

    public function getstudentId(){
        return $this->studentId;
    }

    public function getgrade(){
        return $this->grade;
    }
    
    public function setgrade($grade){
        $qry = $this->dbCon->getPDO()->prepare("UPDATE student SET grade=:phld WHERE id=:siid");
        $qry->execute(array(
            ':phld'=>$grade,
            ':siid'=>$this->studentId));
        $this->grade = $grade;
    }

    public static function getUserId($studentId){
        $qry = DBConn::getInstance()->getPDO()->prepare("SELECT `User`.id FROM `User` JOIN Student ON `User`.id = Student.user_id WHERE Student.id=:sid");
        $qry->execute(array(':sid'=>$studentId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        return$row['id'];
    }

    public function getIndClasses(){
        $qry = $this->dbCon->getPDO()->prepare("SELECT IndividualClass.id FROM Student JOIN IndividualClass ON Student.id=IndividualClass.student_id WHERE Student.id=:sid");
        $qry->execute(array(
            ':sid'=>$this->studentId
        ));
        $classes = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($classes, new IndividualClass($row['id']));
        }
        return $classes;
    }

    public function getGroupClasses(){
        $qry = $this->dbCon->getPDO()->prepare("SELECT GroupClass.id FROM Group_Student JOIN GroupClass ON Student.id=GroupClass.student_id WHERE Student.id=:sid");
        $qry->execute(array(
            ':sid'=>$this->studentId
        ));
        $classes = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($classes, new GroupClass($row['id']));
        }
        return $classes;
    }

    public function getEnrolledTutors(){
        $enrolledTutors = array();
        $qry = $this->dbCon->getPDO()->prepare("SELECT tutor_id from IndividualClass WHERE student_id = :sid;");
        $qry->execute(array(':sid'=>$this->studentId));
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            $user_id = Tutor::getUserId($row['tutor_id']);
            array_push($enrolledTutors, Tutor::getInstance($user_id));
        }
        return $enrolledTutors;
    }


    public function getGroup(): array
    {
        $qry = $this->dbCon->getPDO()->prepare("SELECT `Group`.id FROM Group_Student JOIN `Group` ON Group_Student.group_id=`Group`.id WHERE Group_Student.student_id=:sid");
        $qry->execute(array(':sid'=>$this->studentId));
        $classes = array();
        while($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($classes, new StudentGroup($row['id']));
        }
        return $classes;
    }
}