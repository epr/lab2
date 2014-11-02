<?php
namespace controller;
use model\LoginModel;
use view\LoginView;
use view\HTMLPage;
class LoginController {
    private $model;
    private $view;
    private $loggedIn = false;
    public function __construct(LoginModel $model, LoginView $view) {
        $this->model = $model;
        $this->view = $view;
        $this->checkSession();
        $this->checkCookies();
        $this->showForm();
        $this->createPage();
    }
    public function checkSession() {
        if ($this->model->getSessionUsername() && $this->model->getSessionUserAgent() == $_SERVER["HTTP_USER_AGENT"]) {
            $this->loggedIn = true;
        }
    }
    public function checkCookies() {
        if ($this->view->cookiesAreSet() && $this->loggedIn == false) {
            if ($this->authenticate($this->view->getCookieUsername(), $this->view->getCookiePassword()) && $this->model->checkCookieTime()) {
                $this->view->cookieLoginSuccess();
                $this->loggedIn = true;
            } else {
                $this->view->wrongCookieInfo();
            }
        }
    }
    public function authenticate($username, $password) {
        if ($this->model->authenticate($username, $password)) {
            return true;
        }
        return false;
    }
    public function createPage() {
        $time = $this->view->timeInSwedish();
        $page = new HTMLPage();
        if ($this->loggedIn) {
            $form = $this->view->logoutForm($this->view->getUsername());
        } else {
            $form = $this->view->loginForm();
        }
        echo $page->getPage("Lab 2", "
        <h1>Laborationskod eprcz09</h1>
        $form
        <p>$time</p>");
    }
    public function showForm() {
        if ($this->view->formSubmitted()) {
            $this->loginUser();
        } else if ($this->view->loggedOut()) {
            $this->logoutUser();
        }
    }
    public function loginUser() {
        if ($this->view->usernameEntered()) {
            if ($this->view->passwordEntered()) {
                if ($this->authenticate($this->view->getUsername(), $this->view->getEncryptedPassword())) {
                    $this->view->loginSuccess();
                    $this->loggedIn = true;
                    if ($this->view->getRemember()) {
                        $this->view->setCookies();
                        $this->view->rememberLoginSuccess();
                    }
                } else {
                    $this->view->wrongCredentials();
                }
            } else {
                $this->view->passwordMissing();
            }
        } else {
            $this->view->usernameMissing();
        }
    }
    public function logoutUser() {
        $this->view->logoutSuccess();
        $this->loggedIn = false;
        $this->model->removeSession();
        $this->view->removeCookies();
    }
}