<?php
require_once "DBConn.class.php";
class Subject
{
    private $id;
    private $name;
    private $grade;
    private $medium;
    private $dbCon;
    private static $instances;

    private function __construct($subjectId)
    {
        $this->dbCon = DBConn::getInstance();
        $qry = $this->dbCon->getPDO()->prepare("SELECT SubjectMedium.medium, SubjectName.name, Grade.grade FROM Subject JOIN Grade JOIN SubjectName JOIN SubjectMedium ON
                                                            Subject.name_id = SubjectName.id AND Subject.grade_id=Grade.id AND Subject.medium_id=SubjectMedium.id WHERE Subject.id=:sid");
        $qry->execute(array(':sid'=>$subjectId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->id=$subjectId;
        $this->name=$row['name'];
        $this->grade=$row['grade'];
        $this->medium=$row['medium'];
    }

    final public static function getInstance($subjectId)
    {
        if (!isset(self::$instances[$subjectId])) {
            self::$instances[$subjectId] = new Subject($subjectId);
        }
        return self::$instances[$subjectId];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

//    /**
//     * @param mixed $name
//     */
//    public function setName($name): void
//    {
//        $qry = self::$dbConn->getPDO()->prepare("UPDATE Subject SET name=:phld WHERE id=:sid");
//        $qry->execute(array(
//            ':phld'=>$name,
//            ':sid'=>$this->id));
//        $this->name = $name;
//    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

//    /**
//     * @param mixed $grade
//     */
//    public function setGrade($grade): void
//    {
//        $qry = self::$dbConn->getPDO()->prepare("UPDATE Subject SET grade=:phld WHERE id=:sid");
//        $qry->execute(array(
//            ':phld'=>$grade,
//            ':sid'=>$this->id));
//        $this->grade = $grade;
//    }

    /**
     * @return mixed
     */
    public function getMedium()
    {
        return $this->medium;
    }

//    /**
//     * @param mixed $medium
//     */
//    public function setMedium($medium): void
//    {
//        $qry = self::$dbConn->getPDO()->prepare("UPDATE Subject SET subject_medium=:phld WHERE id=:sid");
//        $qry->execute(array(
//            ':phld'=>$medium,
//            ':sid'=>$this->id));
//        $this->medium = $medium;
//    }
}