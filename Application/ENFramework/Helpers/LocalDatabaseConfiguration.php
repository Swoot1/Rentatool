<?php
/**
 * User: Elin
 * Date: 2014-07-29
 * Time: 09:05
 */

namespace Application\ENFramework\Helpers;


class LocalDatabaseConfiguration implements IDatabaseConfiguration{

   static $host = 'localhost';
   static $username = 'root';
   static $password = 'root';
   static $databaseName = 'rentatool';

   public static function getPDOOptions(){
      return array(
         \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
         \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
         \PDO::MYSQL_ATTR_FOUND_ROWS   => true
      );
   }
}
