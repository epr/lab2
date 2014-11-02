<?php
namespace view;
class HTMLPage {
    public function getPage($title, $body) {
        return "<!doctype html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <title>$title</title>
    </head>
    <body>$body</body>
</html>";
    }
}