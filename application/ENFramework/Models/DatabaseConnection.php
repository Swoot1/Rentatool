<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Models;


use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class DatabaseConnection implements IDatabaseConnection {
   /**
    * @var \PDO
    */
   private $databaseConnection;

   public function __construct() {
      $host         = 'localhost';
      $userName     = 'root';
      $password     = '';
      $databaseName = 'Rentatool';

      $databaseConnection = new \PDO(sprintf('mysql:host=%s;dbname=%s', $host, $databaseName), $userName, $password);
      $databaseConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->databaseConnection = $databaseConnection;
   }

   public function runQuery($query, $params = array()) {
      try{
         $queryResult  = array();
         $DBConnection = $this->databaseConnection;

         $stmt = $DBConnection->prepare($query);
         $stmt->execute($params);

         if($stmt->rowCount() > 0){
            while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
               $queryResult[] = $result;
            }
         }

      }catch(\PDOException $exception){
         throw new ApplicationException('Kunde inte läsa databas.');
      }

      return $queryResult;
   }
}