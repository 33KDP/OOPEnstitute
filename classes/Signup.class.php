<?php
require_once("DBConn.class.php");
session_start();

class LogIn
{
    private $dbCon;

    public function __construct(){
        $this->dbCon = DBConn::getInstance();
    }

    
}