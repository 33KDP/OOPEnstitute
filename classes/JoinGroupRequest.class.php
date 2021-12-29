<?php

require_once "Request.class.php";

class JoinGroupRequest extends Request
{

    /**
     * JoinGroupRequest constructor.
     */
    public function __construct($requestId)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT JoinGroupRequest.group_id, JoinGroupRequest.message, JoinGroupRequest.state,
                                                        JoinGroupRequest.student_id, `Group`.subject_id FROM JoinGroupRequest Join `Group` 
                                                            ON JoinGroupRequest.group_id = `Group`.id WHERE JoinGroupRequest.id=:reqid");
        $qry->execute(array(':reqid'=>$requestId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $receiverId=$row['group_id'];
        $subjectId=$row['subject_id'];
        $message=$row['message'];
        $state= $row['state'];
        $type=2;
        $senderId=$row['student_id'];

        parent::__construct($requestId, $senderId, $receiverId, $subjectId, $message, $state, $type);
    }

    public function accept($form)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("INSERT INTO Group_Student (student_id, group_id) VALUES (:sid, :gid)");
        $qry->execute(array(':sid'=>$form['senderId'], ':gid'=>$form['groupId']));
        self::removeRequest($form['reqId']);
    }

    public function reject($form)
    {
        self::removeRequest($form['reqId']);
    }

    public static function removeRequest($requestId)
    {
        $dbConn =DBConn::getInstance();
        echo $requestId;
        $qry = $dbConn->getPDO()->prepare("DELETE FROM JoinGroupRequest WHERE id=:reqid");
        $qry->execute(array(':reqid'=>$requestId));
        // TODO: Implement removeRequest() method.
    }
}