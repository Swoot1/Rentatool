<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Mappers;

use Application\ENFramework\Models\IDatabaseConnection;
use Application\Filters\RentalObjectFilter;

class RentalObjectMapper{
   /**
    * @var \Application\ENFramework\Models\IDatabaseConnection
    */
   private $databaseConnection;

   private $indexSQL = '
              SELECT
                  rental_objects.id,
                  user_id as "userId",
                  name,
                  price_per_day AS "pricePerDay"
               FROM rental_objects';

   private $createSQL = '
       INSERT INTO
        rental_objects
          (
            user_id,
            name,
            price_per_day
          )
      VALUES
        (
          :userId,
          :name,
          :pricePerDay
        )
    ';

   private $readSQL = '
    SELECT
       id,
       user_id AS "userId",
       name,
       price_per_day AS "pricePerDay"
    FROM
      rental_objects
    WHERE
      id = :id';

   private $updateSQL = '
       UPDATE
           rental_objects
        SET
          user_id = :userId,
          name = :name,
          price_per_day = :pricePerDay
        WHERE
          id = :id
    ';

   private $deleteSQL = '
        DELETE
          FROM
            rental_objects
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
      $result = $this->databaseConnection->runQuery($this->createSQL, $DBParameters);
      return $this->read($result['lastInsertId']);
   }

   public function update(array $DBParameters){
      $this->databaseConnection->runQuery($this->updateSQL, $DBParameters);
      return $this;
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));
      return array_shift($result);
   }

   public function delete($id){
      return $this->databaseConnection->runQuery($this->deleteSQL, array('id' => $id));
   }
}