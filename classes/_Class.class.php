<?php

abstract class _Class
{
    private $class_id;
    private $tutor_id;
    private $subject_id;

    /**
     * _Class constructor.
     */
    public function __construct($class_id,$tutor_id, $subject_id)
    {
        $this->class_id = $class_id;
        $this->tutor_id = $tutor_id;
        $this->subject_id = $subject_id;
    }

    /**
     * @return mixed
     */
    public function getClassId()
    {
        return $this->class_id;
    }

    /**
     * @return mixed
     */
    public function getTutor()
    {
        return $this->tutor_id;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject_id;
    }
    
}






