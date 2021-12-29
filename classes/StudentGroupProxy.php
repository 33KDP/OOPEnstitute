<?php

require_once "IStudentGroup.interface.php";
class StudentGroupProxy implements IStudentGroup {

    private $group_id;
    private $name;
    private $district;
    private $capacity;

    /**
     * StudentGroupProxy constructor.
     * @param $group_id
     */
    public function __construct($group_id)
    {
        $dbConn = DBConn::getInstance();
        $qry = $dbConn->getPDO()->prepare("SELECT *  FROM `Group`  WHERE id=:gid");
        $qry->execute(array(':gid' => $group_id));
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $this->group_id = $row['id'];
        $this->capacity = $row['capacity'];
        $this->name = $row['group_name'];
        $this->subject_id = $row['subject_id'];
        $this->admin = $row['group_admin'];
        $this->created_date = $row['created_date'];
        $this->description = $row['description'];
        $this->district = $row['district_id'];
    }

    private $student_group;

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
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
    public function getDescription()
    {
        return $this->description;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
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
    public function getStudentList()
    {
        $this->student_group = new StudentGroup($this->group_id);
        return $this->student_group->getStudentList();
    }
}