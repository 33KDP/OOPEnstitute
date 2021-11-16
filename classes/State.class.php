<?php

class State
{
}

class Pending extends State{
    private static $instance;
    private function __construct(){}

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new Pending();
        }
        return self::$instance;
    }
}

class Accepted extends State{
    private static $instance;
    private function __construct(){}

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new Accepted();
        }
        return self::$instance;
    }
}
class Rejected extends State{
    private static $instance;
    private function __construct(){}

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new Rejected();
        }
        return self::$instance;
    }
}