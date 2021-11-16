<?php
require_once "_Class.class.php";
require_once "DBConn.class.php";
class IndividualClass extends _Class
{
    private $student_id;

    /**
     * IndividualClass constructor.
     */
    function __construct($class_id,$tutor_id, $subject_id, $student_id)
    {
        $this->$class_id = $class_id;
        $this->$tutor_id = $tutor_id;
        $this->$subject_id = $subject_id;
        $this->$student_id = $student_id;
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
}