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
        $this->showForm();
        $this->createPage();
    }
    public function checkSession() {
        if (isset($_SESSION["username"])) {
            $this->loggedIn = true;
        }
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
        <h1>Laboration 2</h1>
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
                if ($this->model->authenticate($this->view->getUsername(), $this->view->getPassword())) {
                    $this->loggedIn = true;
                    $this->view->loginSuccess();
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
        unset($_SESSION["username"]);
    }
}