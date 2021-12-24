<?php
require_once "_Class.class.php";
require_once "DBConn.class.php";
class GroupClass extends _Class
{
    /**
     * GroupClass constructor.
     */
    private $groupId;
    private $capacity;
    private $district;
    private $created_date;
    private $description;


    function __construct($class_id)
    {
        $dbConn =DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT GroupClass.tutor_id, `Group`.subject_id,`Group`.capacity,
                                                 `Group`.created_date, `Group`.description, district, `Group`.id 
                                                 FROM GroupClass JOIN `Group` ON GroupClass.group_id=`Group`.id 
                                                 WHERE GroupClass.id=:clsid");
        $qry->execute(array(':clsid'=>$class_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $tutor_id = $row['tutor_id'];
        $subject_id = $row['subject_id'];
        $this->groupId = $row['id'];
        $this->capacity = $row['capacity'];
        $this->district = $row['district'];
        $this->created_date = $row['created_date'];
        $this->description = $row['description'];
        parent::__construct($class_id, $tutor_id, $subject_id);
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
                ':sid' => $group
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


}