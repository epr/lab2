<?php
namespace controller;
use model\LoginModel;
use view\LoginView;
use view\HTMLPage;
class LoginController {
    private $model;
    private $view;
    public function __construct(LoginModel $model, LoginView $view) {
        $this->model = $model;
        $this->view = $view;
        $this->createPage();
    }
    public function createPage() {
        $form = $this->view->loginForm();
        $time = $this->view->timeInSwedish();
        $page = new HTMLPage();
        echo $page->getPage("Lab 2", "
        <h1>Laboration 2</h1>
        $form
        <p>$time</p>");
    }
}