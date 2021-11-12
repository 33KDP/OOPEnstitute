<?php

class IndividualClass extends _Class
{
    private $student_id;

    /**
     * IndividualClass constructor.
     */
    function __construct($class_id,$tutor_id, $subject_id, $student_id)
    {
        $this->$class_id = $class_id;
        $this->$tutor_id = $tutor_id;
        $this->$subject_id = $subject_id;
        $this->$student_id = $student_id;
    }
}