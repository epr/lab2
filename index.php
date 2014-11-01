<?php
use view\LoginView;
use model\LoginModel;
use controller\LoginController;

require_once("view/HTMLPage.php");
require_once("view/LoginView.php");
require_once("controller/LoginController.php");
require_once("model/LoginModel.php");

$model = new LoginModel();
$view = new LoginView($model);
new LoginController($model, $view);