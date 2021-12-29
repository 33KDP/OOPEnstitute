<?php

abstract class MessageState
{
    private $value;

    public function __construct($value){
        $this->value = $value;
    }

    public function getStateValue() : int
    {
        return $this->value;
    }

}

class Unread extends MessageState
{
    private static $instance;

    private function __construct($value){
        parent::__construct($value);
    }

    public static function getInstance(){
        if (!isset(self::$instance))
            self::$instance = new Unread(0);
        
        return self::$instance;
    }

}

class Read extends MessageState
{
    private static $instance;
    
    private function __construct($value){
        parent::__construct($value);
    }

    public static function getInstance(){
        if (!isset(self::$instance))
            self::$instance = new Read(1);
        
        return self::$instance;
    }

}
