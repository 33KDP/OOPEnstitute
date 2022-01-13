<?php
require_once "_Class.class.php";
require_once "DBConn.class.php";
class IndividualClass extends _Class
{
    private $timeslot;
    private $student_id;

    /**
     * IndividualClass constructor.
     */
    function __construct($class_id)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT * FROM IndividualClass WHERE id=:clsid");
        $qry->execute(array(':clsid'=>$class_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $class_id = $row['id'];
        $tutor_id = $row['tutor_id'];
        $subject_id = $row['subject_id'];
        $this->student_id = $row['student_id'];
        parent::__construct($class_id, $tutor_id, $subject_id);
    }

    public static function addClass($form){
        if (empty($form['tutorId']) || empty($form['senderId']) || empty($form['subjectId'])) {
            //flash message
        } else{
            $tutor = $form['tutorId'];
            $student = $form['senderId'];
            $subject = $form['subjectId'];
            $qry = DBConn::getInstance()->getPDO()->prepare("INSERT INTO IndividualClass (tutor_id, student_id, subject_id) VALUES (:tid, :sid, :subId)");
            $qry->execute(array(
                ':tid' => $tutor,
                ':sid' => $student,
                ':subId' => $subject
            ));
        }
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->student_id;
    }

    public static function disenroll($form){
        $qry = DBConn::getInstance()->getPDO()->prepare("DELETE FROM IndividualClass WHERE id=:clsid");
        $qry->execute(array(
            ':clsid' => $form['classid']
        ));
        $curUser = Student::getInstance($_SESSION['user_id']);
        $otherParty = Tutor::getInstance(Tutor::getUserId($form['tutorid']));
        $message = 'I have disenrolled from your class';
        $curUser->composeMessage($otherParty, $message, 0);
    }


}