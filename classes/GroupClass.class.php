<?php
require_once "_Class.class.php";
require_once "DBConn.class.php";
require_once "StudentGroup.class.php";

class GroupClass extends _Class
{
    /**
     * GroupClass constructor.
     */
    private $groupId;
    private $studentGroup;

    function __construct($class_id)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT GroupClass.tutor_id, `Group`.subject_id, `Group`.id 
                                                 FROM GroupClass JOIN `Group` ON GroupClass.group_id=`Group`.id 
                                                 WHERE GroupClass.id=:clsid");
        $qry->execute(array(':clsid'=>$class_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $tutor_id = $row['tutor_id'];
        $subject_id = $row['subject_id'];
        $this->groupId = $row['id'];

        parent::__construct($class_id, $tutor_id, $subject_id);
        $this->studentGroup = new StudentGroup($this->groupId);
    }

    public static function addClass($form){
        if (empty($form['tutorId']) || empty($form['senderId']) || empty($form['subjectId'])) {
            //flash message
        } else{
            $tutor = $form['tutorId'];
            $group = $form['senderId'];

            $qry = DBConn::getInstance()->getPDO()->prepare("INSERT INTO GroupClass (tutor_id, group_id) VALUES (:tid, :gid)");
            $qry->execute(array(
                ':tid' => $tutor,
                ':gid' => $group
            ));
        }
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getStudentGroup()
    {
        return $this->studentGroup;
    }

}