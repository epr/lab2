<?php
require_once("view/HTMLPage.php");
$pageView = new \view\HTMLPage();
echo $pageView->getPage("Lab 2", "<h1>Laboration 2</h1>");