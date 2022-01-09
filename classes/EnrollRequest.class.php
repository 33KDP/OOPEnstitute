<?php
require_once "RequestState.class.php";
require_once "Request.class.php";
require_once "GroupClass.class.php";
require_once "Tutor.class.php";
require_once "Student.class.php";

class EnrollRequest extends Request
{
    public function __construct($requestId){
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT * FROM Request WHERE id=:reqid");
        $qry->execute(array(':reqid'=>$requestId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        if ( ($type = $row['type']) == 0){
            $senderId=$row['student_id'];
        }else{
            $senderId=$row['group_id'];
        }
        $receiverId=$row['tutor_id'];
        $subjectId=$row['subject_id'];
        $message=$row['message'];
        if ($row['state'] === 0){
            $state = Pending::getInstance();
        }else if($row['state'] === 1){
            $state = Accepted::getInstance();
        } else {
            $state = Rejected::getInstance();
        }
        parent::__construct($requestId, $senderId, $receiverId, $subjectId, $message, $state, $type);
    }

    public function accept($form)
    {
        $this->setState(Accepted::getInstance());
        $curUser = Tutor::getInstance($_SESSION['user_id']);
        $dbConn =DBConn::getInstance();
        if ($form['type'] == 0){
            $qry = $dbConn->getPDO()->prepare("SELECT * FROM IndividualClass WHERE student_id=:sid AND tutor_id=:tid AND subject_id=:subid");
            $qry->execute(array(
                ':sid'=> $form['senderId'],
                ':tid'=>$form['tutorId'],
                ':subid'=> $form['subjectId']
            ));
            $row = $qry->fetch(PDO::FETCH_ASSOC);
            var_dump($row);
            if ($row !== false){
                $_SESSION['error'] = "Student already enrolled";
            }else{
                IndividualClass::addClass($form);
                $otherParty = Student::getInstance(Student::getUserId($form['senderId']));
                $message = 'Your request has been accepted';
                $curUser->composeMessage($otherParty, $message, 0);
            }

        } else {
            $qry = $dbConn->getPDO()->prepare("SELECT * FROM GroupClass WHERE group_id=:gid AND tutor_id=:tid");
            $qry->execute(array(
                ':gid'=> $form['senderId'],
                ':tid'=>$form['tutorId']
            ));
            $row = $qry->fetch(PDO::FETCH_ASSOC);
            if ($row !== false){
                $_SESSION['error'] = "Group already enrolled";
            }else{
                GroupClass::addClass($form);
                $curGroup = new StudentGroup($form['senderId']);
                $forum = $curGroup->getForum();
                $message = 'Your request has been accepted';
                $curUser->composeMessage($forum, $message, 1);
            }
        }
        self::removeRequest($this->getId());
    }


    public function reject($form)
    {
        $this->setState(Rejected::getInstance());
        $curUser = Tutor::getInstance($_SESSION['user_id']);
        if ($form['type'] == 0){
            $otherParty = Student::getInstance(Student::getUserId($form['senderId']));
            $message = 'Your request has been rejected';
            $curUser->composeMessage($otherParty, $message, 0);
        } else {
            $curGroup = new StudentGroup($form['senderId']);
            $forum = $curGroup->getForum();
            $message = 'Your request has been rejected';
            $curUser->composeMessage($forum, $message, 1);
        }
        self::removeRequest($this->getId());
    }

    public static function removeRequest($requestId)
    {
        $dbConn =DBConn::getInstance();
        echo $requestId;
        $qry = $dbConn->getPDO()->prepare("DELETE FROM Request WHERE id=:reqid");
        $qry->execute(array(':reqid'=>$requestId));
    }
}