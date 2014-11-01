<?php
namespace view;
class LoginView {
    private $model;
    public function __construct() {

    }
    public function timeInSwedish() {
        setlocale(LC_TIME, 'swedish');
        return strftime('%A, den %e %B år %Y. Klockan är [%X]', time());
    }
}