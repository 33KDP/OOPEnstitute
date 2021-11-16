<?php

abstract class _Class
{
    private $class_id;
    private $tutor_id;
    private $subject_id;
    private $occupied_time_slot;
    private $enrollment_requests;
    private $disenrollment_requests;

    /**
     * _Class constructor.
     */
    function __construct($class_id,$tutor_id, $subject_id)
    {
        $this->$class_id = $class_id;
        $this->$tutor_id = $tutor_id;
        $this->$subject_id = $subject_id;
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

    /**
     * @return mixed
     */
    public function getOccupiedTimeSlot()
    {
        return $this->occupied_time_slot;
    }

    /**
     * @param mixed $occupied_time_slot
     */
    public function setOccupiedTimeSlot($occupied_time_slot)
    {
        $this->occupied_time_slot = $occupied_time_slot;
    }

    /**
     * @return mixed
     */
    public function getEnrollmentRequests()
    {
        return $this->enrollment_requests;
    }

    /**
     * @param mixed $enrollment_requests
     */
    public function setEnrollmentRequests($enrollment_requests)
    {
        $this->enrollment_requests = $enrollment_requests;
    }

    /**
     * @return mixed
     */
    public function getDisenrollmentRequests()
    {
        return $this->disenrollment_requests;
    }

    /**
     * @param mixed $disenrollment_requests
     */
    public function setDisenrollmentRequests($disenrollment_requests)
    {
        $this->disenrollment_requests = $disenrollment_requests;
    }
}






