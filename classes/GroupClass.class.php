<?php
require_once "_Class.class.php";
require_once "DBConn.class.php";
class GroupClass extends _Class
{
    private $student_id;

    /**
     * IndividualClass constructor.
     */
    function __construct($class_id)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT * FROM GroupClass WHERE id=:clsid");
        $qry->execute(array(':clsid'=>$class_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $class_id = $row['id'];
        $tutor_id = $row['tutor_id'];
        $subject_id = $row['subject_id'];
        $this->student_id = $row['student_id'];
        parent::__construct($class_id, $tutor_id, $subject_id);
    }

    public static function addClass($form){
        if (empty($form['tutorId']) || empty($form['studentId']) || empty($form['subjectId'])) {
            //flash message
        } else{
            $tutor = $_POST['tutorId'];
            $student = $_POST['studentId'];
            $subject = $_POST['subjectId'];

            $qry = DBConn::getInstance()->getPDO()->prepare("INSERT INTO IndividualClass (tutor_id, student_id, subject_id) VALUES (:tid, :sid, :subId)");
            $qry->execute(array(
                ':tid' => $tutor,
                ':sid' => $student,
                ':subId' => $subject
            ));
        }
        header("location: ../requests.php");
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->student_id;
    }


}