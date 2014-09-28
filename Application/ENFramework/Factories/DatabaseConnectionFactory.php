<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 15/08/14
 * Time: 19:26
 */

namespace Application\ENFramework\Factories;

use Application\ENFramework\Helpers\LocalDatabaseConfiguration;
use Application\ENFramework\Helpers\ProductionDatabaseConfiguration;

class DatabaseConnectionFactory implements IDatabaseConnectionFactory{

   public function getDatabaseConnection(){
      if ($this->isLocalHost()){
         $connection = $this->getLocalDatabaseConnection();
      } else{
         $connection = $this->getProductionDatabaseConnection();
      }

      return $connection;
   }

   private function getLocalDatabaseConnection(){
      return new \PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                              LocalDatabaseConfiguration::$host,
                              LocalDatabaseConfiguration::$databaseName),
                      LocalDatabaseConfiguration::$username,
                      LocalDatabaseConfiguration::$password,
                      LocalDatabaseConfiguration::getPDOOptions());
   }

   private function getProductionDatabaseConnection(){
      return new \PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                              ProductionDatabaseConfiguration::$host,
                              ProductionDatabaseConfiguration::$databaseName),
                      ProductionDatabaseConfiguration::$username,
                      ProductionDatabaseConfiguration::$password,
                      ProductionDatabaseConfiguration::getPDOOptions());

   }

   private function isLocalHost(){
      return $_SERVER["REMOTE_ADDR"] === '::1' || $_SERVER["REMOTE_ADDR"] === '127.0.0.1';
   }
} 