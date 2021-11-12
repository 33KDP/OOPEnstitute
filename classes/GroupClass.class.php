<?php

class GroupClass extends _Class
{
    private $student_group_id;

    /**
     * GroupClass constructor.
     */
    function __construct($class_id,$tutor_id, $subject_id, $student_id, $student_group_id)
    {
        $this->$class_id = $class_id;
        $this->$tutor_id = $tutor_id;
        $this->$subject_id = $subject_id;
        $this->$student_group_id = $student_id;
    }
}