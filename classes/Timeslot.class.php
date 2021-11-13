<?php
require_once "DBConn.class.php";
require_once "User.class.php";
class Timeslot
{
    private  $timeslotId;
    private  $startTime;
    private  $endTime;
    private  $day;
    private $tutorId;
    private static $dbConn;
    private  $notAvailable;
    private static $instances;

    private function __construct($timeslotId){
        $this->timeslotId = $timeslotId;
        $qry = self::$dbConn->getPDO()->prepare("SELECT * FROM TimeSlot WHERE id=:timeid");
        $qry->execute(array(':timeid'=>$timeslotId));
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        $this->startTime=$row['start_time'];
        $this->endTime=$row['end_time'];
        $this->day=$row['day'];
        $this->tutorId = $row['tutor_id'];
       $this->notAvailable=$row['state'];
    }

    public static function init(){
        self::$dbConn = DBConn::getInstance();
        self::$instances= array();
    }


    public static function getMinutes($time){
        $time = array_map('intval', explode(':',$time));
        $hrs = $time[0];
        $mins = $time[1];
        return $hrs*60+$mins;
    }


    public static function getTime12($time)
    {
        $hrs = intdiv($time,60);
        if ($hrs > 12){
            $abr = "pm";
            $hrs = abs($hrs -12);
        } else{
            $abr = "am";
        }
        $mins = $time%60;
        if ($mins == 0) {
            $mins = "00";
        }
        if ($hrs == 0) {
            $hrs = "12";
        }
        return $hrs.'.'.$mins.' '.$abr;
    }

    public static function getTime24($time)
    {
        $hrs = intdiv($time,60);
        $mins = $time%60;
        if ($mins == 0) {
            $mins = "00";
        }
        if ($hrs == 0) {
            $hrs = "00";
        } elseif ($hrs < 10){
            $hrs = "0".$hrs;
        }
        return $hrs.':'.$mins;
    }

    final public static function getInstance($timeslotId)
    {
        if (!isset(self::$instances[$timeslotId])) {
            self::$instances[$timeslotId] = new Timeslot( $timeslotId);
        }
        return self::$instances[$timeslotId];
    }


    public function getTimeslotId()
    {
        return $this->timeslotId;
    }


    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $qry = self::$dbConn->getPDO()->prepare("UPDATE TimeSlot SET start_time=:phld WHERE id=:timeid");
        $qry->execute(array(
            ':phld'=>$startTime,
            ':timeid'=>$this->timeslotId));
        $this->startTime = $startTime;
    }


    public function getEndTime()
    {
        return $this->endTime;
    }


    public function setEndTime($endTime)
    {
        $qry = self::$dbConn->getPDO()->prepare("UPDATE TimeSlot SET end_time=:phld WHERE id=:timeid");
        $qry->execute(array(
            ':phld'=>$endTime,
            ':timeid'=>$this->timeslotId));
        $this->endTime = $endTime;
    }


    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        $qry = self::$dbConn->getPDO()->prepare("UPDATE TimeSlot SET day=:phld WHERE id=:timeid");
        $qry->execute(array(
            ':phld'=>$day,
            ':timeid'=>$this->timeslotId));
        $this->day = $day;
    }

    public function getNotAvailable()
    {
        return $this->notAvailable;
    }

    public function setNotAvailable($notAvailable)
    {
        $qry = self::$dbConn->getPDO()->prepare("UPDATE TimeSlot SET start_time=:phld WHERE id=:timeid");
        if ($notAvailable){
            $val = 1;
        } else {
            $val = 0;
        }
        $qry->execute(array(
            ':phld'=>$val,
            ':timeid'=>$this->timeslotId));
        $this->notAvailable = $notAvailable;
    }

    public function getTutorId()
    {
        return $this->tutorId;
    }

    public function setTutorId($tutorId)
    {
        $this->tutorId = $tutorId;
    }


    public static function addTimeslot($form){
        if (empty($form['dayInput']) || empty($form['startTime']) || empty($form['endTime'])) {
            //flash message
        } else{
            $day = $_POST['dayInput'];
            $start = self::getMinutes($_POST['startTime']);
            $end = self::getMinutes($_POST['endTime']);
            $tutorid = $_POST['tutorid'];

            $qry = self::$dbConn->getPDO()->prepare("INSERT INTO TimeSlot (tutor_id, day, start_time, end_time) VALUES (:tid, :day, :start, :end)");
            $qry->execute(array(
                ':tid' => $tutorid,
                ':day' => $day,
                ':start' => $start,
                ':end' => $end
            ));
        }
        header("location: timeslots.php");
    }

    public function editTimeSlot($form){
        if (empty($form['dayInput']) || empty($form['startTime']) || empty($form['endTime'])) {
            //flash message
        } else{
            $day = $_POST['dayInput'];
            $start = self::getMinutes($_POST['startTime']);
            $end = self::getMinutes($_POST['endTime']);

            $this->setDay($day);
            $this->setStartTime($start);
            $this->setEndTime($end);
        }
        header("location: timeslots.php");
    }

    public static function deleteTimeSlot($timeSlotId){
        $qry = self::$dbConn->getPDO()->prepare("DELETE FROM Timeslot WHERE id=:timeid");
        $qry->execute(array(
            ':timeid' => $timeSlotId
        ));
        unset(self::$instances[$timeSlotId]);
        //flash message
        header("location: timeslots.php");
    }
}

Timeslot::init();