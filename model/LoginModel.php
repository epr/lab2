<?php
namespace model;
class LoginModel {
    private $username;
    private $password;
    private $sessionName = "username";
    public function __construct() {
        session_start();
        $this->username = "Admin";
        $this->password = "Password";
    }
    public function authenticate($username, $password) {
        if ($this->username == $username && $this->password == $password) {
            $_SESSION[$this->sessionName] = $username;
            return true;
        }
        return false;
    }
    public function removeSession() {
        session_destroy();
    }
    public function getSessionUsername() {
        if (isset($_SESSION[$this->sessionName])) {
            return $_SESSION[$this->sessionName];
        }
        return false;
    }
}

