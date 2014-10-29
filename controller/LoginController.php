<?php
namespace controller;
use model;
use view;
class LoginController {
    private $model;
    private $view;
    public function __construct() {
        $this->model = new LoginModel();
        $this->view = new LoginView();
    }
}