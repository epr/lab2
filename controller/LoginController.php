<?php
namespace controller;
use model;
use view;
class LoginController {
    private $model;
    private $view;
    public function __construct(model\LoginModel $model, view\LoginView $view) {
        $this->model = $model;
        $this->view = $view;
    }
}