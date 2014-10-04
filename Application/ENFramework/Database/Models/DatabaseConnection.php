<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Database\Models;

use Application\ENFramework\Database\Factories\IDatabaseConnectionFactory;
use Application\ENFramework\Database\IMySQLValueFormatter;

/**
 * Class DatabaseConnection
 * @package Application\ENFramework\Models
 */
class DatabaseConnection implements IDatabaseConnection{
   /**
    * @var \PDO
    */
   private $databaseConnection;
   private $mySQLValueFormatter;

   public function __construct(IDatabaseConnectionFactory $databaseConnectionFactory, IMySQLValueFormatter $mySQLValueFormatter){
      $this->databaseConnection  = $databaseConnectionFactory->build();
      $this->mySQLValueFormatter = $mySQLValueFormatter;
   }

   /**
    * Prepares and executes the provided query and params and returns the result from the query.
    * @param $query
    * @param array $params
    * @return array
    */
   public function runQuery($query, $params = array()){
      $stmt = $this->databaseConnection->prepare($query);
      $stmt->execute($params);

      return $this->getResult($stmt);
   }

   private function getResult($stmt){
      $queryHasResultRows = $stmt->columnCount() > 0;

      if ($queryHasResultRows){
         $queryResult = $this->getRows($stmt);
      } else{
         $queryResult['lastInsertId'] = (int)$this->databaseConnection->lastInsertId();
      }

      return $queryResult;
   }

   private function getRows($stmt){
      $queryResult = [];
      $i           = 0;

      while ($row = $stmt->fetch()){
         $columnMeta    = $stmt->getColumnMeta($i);
         $queryResult[] = $this->mySQLValueFormatter->formatValue($row, $stmt, $columnMeta);
         $i++;
      }

      return $queryResult;
   }
}