<?php
require_once "State.class.php";
require_once "Request.class.php";

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

}