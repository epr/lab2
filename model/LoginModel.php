<?php
namespace model;
class LoginModel {
    private $username;
    private $password;
    private $sessionName = "username";
    private $cookieTimeFile = "time.txt";
    public function __construct() {
        session_start();
        $this->username = "Admin";
        $this->password = "Password";
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
    public function authenticate($username, $password) {
        if ($this->username == $username && $this->encrypt($this->password) == $password) {
            $_SESSION[$this->sessionName] = $username;
            return true;
        }
        return false;
    }
    public function encrypt($string) {
        return crypt($string, "NaCl");
    }
    public function saveCookieTime($time) {
        $openedFile = fopen($this->cookieTimeFile, "w");
        fwrite($openedFile, $time);
        fclose($openedFile);
    }
    public function checkCookieTime() {
        $openedFile = fopen($this->cookieTimeFile, "r");
        $time = fread($openedFile, filesize($this->cookieTimeFile));
        fclose($openedFile);
        return ($time > time());
    }
}