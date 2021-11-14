<?php

class DBConn
{
    private $serverName;
    private $dbUserName;
    private $dbPassword;
    private $dbName;
    private $pdo;
    private static $instance;

    private function  __construct()
    {
        $this->serverName = "localhost";
        $this->dbUserName = "enstitute";
        $this->dbPassword = "33kdp";
        $this->dbName = "Enstitute";
        try {
            $this->pdo = new PDO("mysql:host=".$this->serverName.";port=3306;dbname=".$this->dbName, $this->dbUserName, $this->dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            header("location: ../OOPEnstitute/index.php?error=database_connect_error");
            $message = $error->getMessage();
        }
    }

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new DBConn();
        }
        return self::$instance;
    }

    public function getPDO(){
        return $this->pdo;
    }
}