<?php
namespace model;
class LoginModel {
    private $username;
    private $password;
    public function __construct() {
        session_start();
        $this->username = "Admin";
        $this->password = "Password";
    }
    public function authenticate($username, $password) {
        if ($this->username == $username && $this->password == $password) {
            $_SESSION["username"] = $username;
            return true;
        }
        return false;
    }
}

