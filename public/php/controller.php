<?php


$route = 'user';


switch ($route) {
    case 'user': default:
        require_once('controllers/user.php');
        $instance = new User_Controller();
        echo $instance->result;
    break;
}