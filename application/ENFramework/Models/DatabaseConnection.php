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
      $databaseConnection       = new \PDO(sprintf('mysql:host=%s;dbname=%s', // TODO this should be dependency injected.
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
         $i = 0;

         while ($row = $stmt->fetch()) {
            $columnMeta = $stmt->getColumnMeta($i);

            if (is_array($row)) { // TODO refactor
               $k = 0;
               foreach ($row as $key => $column) {
                  $columnMeta = $stmt->getColumnMeta($k); // getColumnMeta() is experimental and can change in a future release of php.
                  $row[$key]  = $this->convertStringToType($column, $columnMeta);
                  $k++;
               }
            } else {
               $row = $this->convertStringToType($row, $columnMeta);
            }

            $queryResult[] = $row;
            $i++;
         }
      }

      return $queryResult;
   }

   /**
    * Since mySQL only returns string the values has to be cast to their proper type. I.e. integer '1' will return 1.
    * @param $value
    * @param array $columnMeta
    * @return string
    */
   private function convertStringToType($value, array $columnMeta) {
      $type = $this->getTypeFromColumnMeta($columnMeta);

      if ($type !== 'string' && is_string($value)) {
         settype($value, $type);
      }

      return $value;
   }

   /**
    * Return the php type that the database type represents.
    * @param array $columnMeta
    * @return string
    */
   private function getTypeFromColumnMeta(array $columnMeta) {

      $nativeType = $columnMeta['native_type'];
      $typeMap    = array(
         'LONG'       => 'int',
         'TINY'       => 'bool',
         'VAR_STRING' => 'string'
      );

      return array_key_exists($nativeType, $typeMap) ? $typeMap[$nativeType] : 'string';
   }
}