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
    public function __construct(LoginModel $model) {
        $this->model = $model;
    }
    public function timeInSwedish() {
        setlocale(LC_TIME, 'swedish');
        return strftime('%A, den %e %B år %Y. Klockan är [%X].', time());
    }
    public function loginForm() {
        return "
        <h2>Ej Inloggad</h2>
        <form action=\"\" method=\"post\" name=\"login\">
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
        <form action=\"\" method=\"post\" name=\"logout\">
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
        return $_POST[$this->usernameName];
    }
    public function getPassword() {
        return $_POST[$this->passwordName];
    }
    public function getRemember() {
        if (isset($_POST[$this->rememberName])) {
            return $_POST[$this->rememberName];
        }
        return "";
    }
    public function formSubmitted() {
        return isset($_POST[$this->submitName]);
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
    public function loggedOut() {
        return isset($_POST[$this->logoutName]);
    }
    public function logoutSuccess() {
        $this->feedbackMessage = "Du har nu loggat ut";
    }
}