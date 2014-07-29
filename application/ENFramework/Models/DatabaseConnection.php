<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Models;

use Rentatool\Application\ENFramework\Helpers\DatabaseConfiguration;

/**
 * Class DatabaseConnection
 * @package Rentatool\Application\ENFramework\Models
 */
class DatabaseConnection implements IDatabaseConnection {
   /**
    * @var \PDO
    */
   private $databaseConnection;

   public function __construct() {
      $databaseConnection       = new \PDO(sprintf('mysql:host=%s;dbname=%s',
                                                   DatabaseConfiguration::$host,
                                                   DatabaseConfiguration::$databaseName),
                                           DatabaseConfiguration::$username,
                                           DatabaseConfiguration::$password,
                                           DatabaseConfiguration::getPDOOptions());
      $this->databaseConnection = $databaseConnection;
   }

   /**
    * Prepares and executes the provided query and params and returns the result from the query.
    * @param $query
    * @param array $params
    * @return array
    */
   public function runQuery($query, $params = array()) {

      $stmt = $this->databaseConnection->prepare($query);
      $stmt->execute($params);

      $queryResult        = [];
      $queryHasResultRows = $stmt->columnCount() > 0;

      if ($queryHasResultRows) {
         while ($row = $stmt->fetch()) {
            $queryResult[] = $row;
         }
      }

      return $queryResult;
   }
}