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

      // Execute tries to set LIMIT as a string but that's incorrect syntax. Emulate off makes it work.
      self::$instance->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

      return self::$instance;
   }
}
