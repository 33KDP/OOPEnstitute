<?php
session_start();
require_once("User.class.php");
require_once("Student.class.php");
require_once("Tutor.class.php");

class Session
{
    private static $user;
    private static $errMsg;
    private static $successMsg;
    private static $loggedIn;

    public static function init(){
        if (isset($_SESSION['user_id'])){
            self::$loggedIn=true;
        } else {
            self::$loggedIn=false;
        }
    }
    
    public static function getUser()
    {
        return self::$user;
    }

    public static function setUser($user)
    {
        self::$user = $user;
    }

    public static function getErrMsg()
    {
        $txt = self::$errMsg;
        self::$errMsg = "";
        return $txt;
    }

    public static function setErrMsg($errMsg)
    {
        self::$errMsg = $errMsg;
    }

    public static function getSuccessMsg()
    {
        $txt = self::$successMsg;
        self::$successMsg = "";
        return $txt;
    }

    public static function setSuccessMsg($successMsg)
    {
        self::$successMsg = $successMsg;
    }

    public static function setLoggedIn($loggedIn): void
    {
        self::$loggedIn = $loggedIn;
    }

    public static function isLoggedIn()
    {
        return self::$loggedIn;
    }
}
Session::init();


