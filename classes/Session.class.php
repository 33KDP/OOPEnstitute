<?php
require_once("User.class.php");
require_once("Student.class.php");
require_once("Tutor.class.php");

class Session
{
    private User $user;
    private String $errMsg;
    private String $successMsg;
    private static Session $instance;
    private bool $loggedIn;

    private function __construct(){
        $this->loggedIn = false;
    }

    public static function getInstance() : Session{
        if (!isset(self::$instance)){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return String
     */
    public function getErrMsg(): string
    {
        $txt = $this->errMsg;
        $this->errMsg = "";
        return $txt;
    }

    /**
     * @param String $errMsg
     */
    public function setErrMsg(string $errMsg): void
    {
        $this->errMsg = $errMsg;
    }

    /**
     * @return String
     */
    public function getSuccessMsg(): string
    {
        $txt = $this->successMsg;
        $this->successMsg = "";
        return $txt;
    }

    /**
     * @param String $successMsg
     */
    public function setSuccessMsg(string $successMsg): void
    {
        $this->successMsg = $successMsg;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    /**
     * @param bool $loggedIn
     */
    public function setLoggedIn(bool $loggedIn): void
    {
        $this->loggedIn = $loggedIn;
    }
}