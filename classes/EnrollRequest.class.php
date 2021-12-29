<?php
require_once "RequestState.class.php";
require_once "Request.class.php";
require_once "GroupClass.class.php";

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
                //flash already enrolled
            }else{
                var_dump($form);
                IndividualClass::addClass($form);
            }
            //notify student
        } else {
            $qry = $dbConn->getPDO()->prepare("SELECT * FROM GroupClass WHERE group_id=:gid AND tutor_id=:tid");
            $qry->execute(array(
                ':gid'=> $form['senderId'],
                ':tid'=>$form['tutorId']
            ));
            $row = $qry->fetch(PDO::FETCH_ASSOC);
            if ($row !== false){
                //flash already enrolled
            }else{
                GroupClass::addClass($form);
            }
            //notify group
        }
        self::removeRequest($this->getId());
    }


    public function reject($form)
    {
        $this->setState(Rejected::getInstance());
        if ($form['type'] == 0){
            //notify student
        } else {
            //notify group
        }
        self::removeRequest($this->getId());
    }

    public static function removeRequest($requestId)
    {
        $dbConn =DBConn::getInstance();
        echo $requestId;
        $qry = $dbConn->getPDO()->prepare("DELETE FROM Request WHERE id=:reqid");
        $qry->execute(array(':reqid'=>$requestId));
        // TODO: Implement removeRequest() method.
    }
}