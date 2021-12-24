<?php

abstract class MessageState
{
    abstract public function getStateValue() : int;
}

class Unread extends MessageState
{
    private static $instance;

    private function __construct() { }

    public static function getInstance(){
        if (!isset(self::$instance))
            self::$instance = new Unread();
        
        return self::$instance;
    }

    public function getStateValue(): int
    {
        return 0;
    }

}

class Read extends MessageState
{
    private static $instance;

    private function __construct() { }

    public static function getInstance(){
        if (!isset(self::$instance))
            self::$instance = new Read();
        
        return self::$instance;
    }

    public function getStateValue(): int
    {
        return 1;
    }

}
