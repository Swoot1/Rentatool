<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 15/08/14
 * Time: 19:26
 */

namespace Rentatool\Application\ENFramework\Factories;

use Rentatool\Application\ENFramework\Helpers\DatabaseConfiguration;

class DatabaseConnectionFactory implements IDatabaseConnectionFactory{

   public function getDatabaseConnection(){
      return new \PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                              DatabaseConfiguration::$host,
                              DatabaseConfiguration::$databaseName),
                      DatabaseConfiguration::$username,
                      DatabaseConfiguration::$password,
                      DatabaseConfiguration::getPDOOptions());
   }
} 