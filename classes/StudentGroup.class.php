<?php

require_once "DBConn.class.php";
require_once "IStudentGroup.interface.php";
require_once "Forum.class.php";

class StudentGroup implements IStudentGroup
{
    private $groupId;
    private $capacity;
    private $description;
    private $name;
    private $subject_id;
    private $admin;
    private $created_date;
    private $student_list;
    private $district;
    private $forum;

    function __construct($group_id)
    {
        $dbConn = DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT *  FROM `Group`  WHERE id=:gid");
        $qry->execute(array(':gid' => $group_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $this->groupId = $row['id'];
        $this->capacity = $row['capacity'];
        $this->name = $row['group_name'];
        $this->subject_id = $row['subject_id'];
        $this->admin = $row['group_admin'];
        $this->created_date = $row['created_date'];
        $this->description = $row['description'];
        $this->district = $row['district_id'];

        $qry = $dbConn->getPDO()->prepare("SELECT *  FROM `Group_Student`  WHERE group_id=:gid");
        $qry->execute(array(':gid' => $group_id));
        $this->student_list = array();

        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {

            $student = Student::getInstance(Student::getUserId($row['student_id']));
            array_push($this->student_list, $student);
        }

        $this->forum = new Forum($group_id);
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @return mixed
     */
    public function getStudentList()
    {
        return $this->student_list;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function isClass() {
        $dbConn = DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT *  FROM GroupClass  WHERE id=:gid");
        $qry->execute(array(':gid' => $this->groupId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            return true;
        } else {
            return false;
        }
    }

}