<?php
require_once("User.class.php");
require_once("Session.class.php");

class Student extends User
{
    private $grade;
    private $studentId;

    public function __contruct($userId)
    {
        parent::__contruct($userId);
        $qry = $this->dbCon->getPDO()->prepare("SELECT Student.grade, Student.id FROM `User` JOIN Student ON `User`.id = Student.user_id WHERE `User`.id=:uid");
        $qry->execute(array(':uid'=>$userId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->grade=$row['grade'];
        $this->studentId=$row['id'];
    }
}