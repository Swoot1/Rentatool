<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 29/07/14
 * Time: 07:55
 */


if(array_key_exists('REQUEST_URI', $_SERVER)){
   $_SERVER['REQUEST_URI'] = str_replace('/rentatool/', '', $_SERVER['REQUEST_URI']);
}

define('PROJECT_ROOT', '/Applications/MAMP/htdocs');