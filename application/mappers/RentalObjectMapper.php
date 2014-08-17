<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;
use Rentatool\Application\Filters\RentalObjectFilter;

class RentalObjectMapper{
   /**
    * @var \Rentatool\Application\ENFramework\Models\IDatabaseConnection
    */
   private $databaseConnection;

   private $indexSQL = '
              SELECT
                  rental_object.id,
                  user_id,
                  name,
                  available
               FROM rental_object';

   private $createSQL = '
       INSERT INTO
        rental_object
          (
            user_id,
            name,
            available
          )
      VALUES
        (
          :userId,
          :name,
          :available
        )
    ';

   private $readSQL = '
    SELECT
       id,
       user_id AS "userId",
       name,
       available
    FROM
      rental_object
    WHERE
      id = :id';

   private $updateSQL = '
       UPDATE
           rental_object
        SET
          user_id = :userId,
          name = :name,
          available = :available
        WHERE
          id = :id
    ';

   private $deleteSQL = '
        DELETE
          FROM
            rental_object
        WHERE
          id = :id

    ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function index(RentalObjectFilter $rentalObjectFilter){
      $query         = $rentalObjectFilter->getFilterQuery($this->indexSQL);
      $rentalObjects = $this->databaseConnection->runQuery($query, $rentalObjectFilter->getFilterParams());

      return $rentalObjects;
   }

   public function create(array $DBParameters){
      unset($DBParameters['id']);
      $query = $this->createSQL;

      return $this->databaseConnection->runQuery($query, $DBParameters);
   }

   public function update(array $DBParameters){
      $query = $this->updateSQL;

      return $this->databaseConnection->runQuery($query, $DBParameters);
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));

      return array_shift($result);
   }

   public function delete($id){
      $query = $this->deleteSQL;

      return $this->databaseConnection->runQuery($query, array('id' => $id));
   }
}