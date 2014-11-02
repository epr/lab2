<?php
namespace model;
class LoginModel {
    private $username;
    private $password;
    private $sessionName = "username";
    private $sessionAgent = "agent";
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
    public function getSessionUserAgent() {
        return $_SESSION[$this->sessionAgent];
    }
    public function authenticate($username, $password) {
        if ($this->username == $username && $this->encrypt($this->password) == $password) {
            $_SESSION[$this->sessionName] = $username;
            $_SESSION[$this->sessionAgent] = $_SERVER["HTTP_USER_AGENT"];
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