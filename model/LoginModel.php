<?php
namespace model;
class LoginModel {
    private $username;
    private $password;
    public function __construct() {
        $this->username = "Admin";
        $this->password = "Password";
    }
    public function authenticate($username, $password) {
        if ($this->username == $username && $this->password == $password) {
            return true;
        }
        return false;
    }
}

