<?php
require_once "../includes/dbh.inc.php";

function getMinutes($time){
    $time = array_map('intval', explode(':',$time));
    $hrs = $time[0];
    $mins = $time[1];
    return $hrs*60+$mins;
}


function getTime12($time): string
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

function getTime24($time): string
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

function getId($usertype, $userid){
    global $conn;
    if ($usertype === 1){
        $qry = $conn->prepare("SELECT `Student`.`id` FROM `User` JOIN `Student` ON `User`.`id` = `Student`.`user_id` 
                                                         WHERE `User`.`id`=:uid");
    } else {
        $qry = $conn->prepare("SELECT `Tutor`.`id` FROM `User` JOIN `Tutor` ON `User`.`id` = `Tutor`.`user_id` 
                                                         WHERE `User`.`id`=:uid");
    }
    $qry->execute(array(
        ":uid" => $userid
    ));
    $row = $qry->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}

