<?php
namespace view;
use model\LoginModel;
class LoginView {
    private $model;
    private $usernameName = "username";
    private $passwordName = "password";
    private $rememberName = "remember";
    private $submitName = "submit";
    private $logoutName = "logout";
    private $feedbackMessage = "";
    private $cookieUsername = "name";
    private $cookiePassword = "pass";
    public function __construct(LoginModel $model) {
        $this->model = $model;
    }
    public function timeInSwedish() {
        setlocale(LC_ALL, 'sv_SE.UTF-8');
        return strftime('%A, den %e %B år %Y. Klockan är [%X].', time());
    }
    public function loginForm() {
        return "
        <h2>Ej Inloggad</h2>
        <form action=\"#\" method=\"post\" name=\"login\">
            <fieldset>
                <legend>Login - Skriv in användarnamn och lösenord</legend>
                $this->feedbackMessage
                <div>
                    <label for=\"name\">Namn: </label>
                    <input type=\"text\" name=\"$this->usernameName\" id=\"name\" value=\"\">
                    <label for=\"pass\">Lösenord: </label>
                    <input type=\"password\" name=\"$this->passwordName\" id=\"pass\">
                    <label for=\"remember\">Håll mig inloggad: </label>
                    <input type=\"checkbox\" name=\"$this->rememberName\" id=\"remember\">
                    <input type=\"submit\" name=\"$this->submitName\" value=\"Logga in\">
                </div>
            </fieldset>
        </form>
        ";
    }
    public function logoutForm($username) {
        return "
        <h2>$username är inloggad</h2>
        $this->feedbackMessage
        <form action=\"#\" method=\"post\" name=\"logout\">
            <input type=\"submit\" name=\"$this->logoutName\" value=\"Logga ut\">
        </form>
        ";
    }
    public function usernameEntered() {
        return (isset($_POST[$this->usernameName]) && $_POST[$this->usernameName] != "");
    }
    public function passwordEntered() {
        return (isset($_POST[$this->passwordName]) && $_POST[$this->passwordName] != "");
    }
    public function getUsername() {
        if ($this->usernameEntered()) {
            return $_POST[$this->usernameName];
        }
        return $this->model->getSessionUsername();
    }
    public function getPassword() {
        return $_POST[$this->passwordName];
    }
    public function getEncryptedPassword() {
        return $this->model->encrypt($this->getPassword());
    }
    public function getRemember() {
        if (isset($_POST[$this->rememberName])) {
            return $_POST[$this->rememberName];
        }
        return false;
    }
    public function formSubmitted() {
        return isset($_POST[$this->submitName]);
    }
    public function loggedOut() {
        return isset($_POST[$this->logoutName]);
    }
    public function usernameMissing() {
        $this->feedbackMessage = "Användarnamn saknas";
    }
    public function passwordMissing() {
        $this->feedbackMessage = "Lösenord saknas";
    }
    public function wrongCredentials() {
        $this->feedbackMessage = "Felaktigt användarnamn och/eller lösenord";
    }
    public function loginSuccess() {
        $this->feedbackMessage = "Inloggning lyckades";
    }
    public function logoutSuccess() {
        $this->feedbackMessage = "Du har nu loggat ut";
    }
    public function rememberLoginSuccess() {
        $this->feedbackMessage = "Inloggning lyckades och vi kommer ihåg dig nästa gång";
    }
    public function cookieLoginSuccess() {
        $this->feedbackMessage = "Inloggning lyckades via cookies";
    }
    public function wrongCookieInfo() {
        $this->feedbackMessage = "Felaktig information i cookie";
        $this->removeCookies();
    }
    public function setCookies() {
        $cookieTime = time() + 2592000; //30 days
        setcookie($this->cookieUsername, $this->getUsername(), $cookieTime);
        setcookie($this->cookiePassword, $this->getEncryptedPassword(), $cookieTime);
        $this->model->saveCookieTime($cookieTime);
    }
    public function removeCookies() {
        setcookie($this->cookieUsername, "", time() - 60);
        setcookie($this->cookiePassword, "", time() - 60);
    }
    public function cookiesAreSet() {
        return (isset($_COOKIE[$this->cookieUsername]) && isset($_COOKIE[$this->cookiePassword]));
    }
    public function getCookieUsername() {
        return $_COOKIE[$this->cookieUsername];
    }
    public function getCookiePassword() {
        return $_COOKIE[$this->cookiePassword];
    }
}