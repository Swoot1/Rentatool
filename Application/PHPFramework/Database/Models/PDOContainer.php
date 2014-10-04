<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-01
 * Time: 22:09
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Database\Models;


class PDOContainer{

   private static $instance;

   private function __construct(){
   }

   public static function getInstance($dsn, $username, $password, $options){
      if (self::$instance instanceof \PDO === false){
         self::$instance = new \PDO($dsn, $username, $password, $options);
      }

      return self::$instance;
   }
}
