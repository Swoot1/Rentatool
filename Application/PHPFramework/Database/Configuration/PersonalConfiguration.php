<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-31
 * Time: 19:16
 * To change this template use File | Settings | File Templates.
 */

if(array_key_exists('REQUEST_URI', $_SERVER)){
   $_SERVER['REQUEST_URI'] = str_replace('/rentatool/', '', $_SERVER['REQUEST_URI']);
}

define('PROJECT_ROOT', 'D:/wamp/www');