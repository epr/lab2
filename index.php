<?php
require_once("view/HTMLPage.php");
require_once("view/LoginView.php");
require_once("controller/LoginController.php");
require_once("model/LoginModel.php");
$pageView = new \view\HTMLPage();
$view = new \view\LoginView();
$time =  $view->timeInSwedish();
echo $pageView->getPage("Lab 2", "<h1>Laboration 2</h1> $time");




