<?php
namespace view;
use model\LoginModel;
class LoginView {
    private $model;
    private $usernameName = "username";
    private $passwordName = "password";
    private $rememberName = "remember";
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
        <form action=\"?login\" method=\"post\" name=\"login\">
            <fieldset>
                <legend>Login - Skriv in användarnamn och lösenord</legend>
                <label for=\"name\">Namn: </label>
                <input type=\"text\" name=\"$this->usernameName\" id=\"name\" value=\"\">
                <label for=\"pass\">Lösenord: </label>
                <input type=\"password\" name=\"$this->passwordName\" id=\"pass\">
                <label for=\"remember\">Håll mig inloggad: </label>
                <input type=\"checkbox\" name=\"$this->remember\" id=\"remember\">
                <input type=\"submit\" name=\"submit\" value=\"Logga in\">
            </fieldset>
        </form>
        ";
    }
    public function getUsername() {
        if (isset($_POST[$this->usernameName])) {
            return $_POST[$this->usernameName];
        }
        return "";
    }
    public function getPassword() {
        if (isset($_POST[$this->passwordName])) {
            return $_POST[$this->passwordName];
        }
        return "";
    }
    public function getRemember() {
        if (isset($_POST[$this->rememberName])) {
            return $_POST[$this->rememberName];
        }
        return "";
    }
}