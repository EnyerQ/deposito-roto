<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 13/09/2015
 * Time: 1:34 AM
 */
use \vista\Vista;
class WelcomeController {

    public function index(){
        return Vista::crear("auth/login");
    }

}
