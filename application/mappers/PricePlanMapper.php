<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 16:33
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class PricePlanMapper {
   private  $databaseConnection;

   private $createSQL = '
      INSERT INTO
        price_plans
          (
            rental_object_id,
            time_unit_id,
            price
          )
          VALUES
          (
            :rentalObjectId,
            :timeUnitId,
            :price
          )

   ';

   private $readCollectionFromRentalObjectIdSQL = '
      SELECT
         id,
         rental_object_id AS "rentalObjectId",
         time_unit_id AS "timeUnitId",
         price
      FROM
        price_plans
      WHERE
         rental_object_id = :rentalObjectId
   ';

   private $readSQL = '
      SELECT
         id,
         rental_object_id AS "rentalObjectId",
         time_unit_id AS "timeUnitId",
         price
      FROM
        price_plans
      WHERE
         id = :id
   ';

   private $deleteSQL = '
      DELETE FROM
         price_plans
      WHERE
         id = :id
   ';

   private $pricePlanExistsSQL = '
      SELECT
      (
        SELECT
          COUNT(id)
        FROM
          price_plans
        WHERE
          rental_object_id = :rentalObjectId
        AND
          time_unit_id = :timeUnitId
       )
       AS "numberOfExistingPricePlans";
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $data){
      unset($data['id']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $data);

      return $this->read($result['lastInsertId']);
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));
      return array_shift($result);
   }

   public function readCollectionFromRentalObjectId($rentalObjectId){
      return $this->databaseConnection->runQuery($this->readCollectionFromRentalObjectIdSQL,
                                          array('rentalObjectId' => $rentalObjectId));
   }

   public function delete($id){
      $this->databaseConnection->runQuery($this->deleteSQL, array('id' => $id));
      return $this;
   }

   public function isUniquePlan($rentalObjectId, $timeUnitId){
      $result = $this->databaseConnection->runQuery($this->pricePlanExistsSQL, array(
         'rentalObjectId' => $rentalObjectId,
         'timeUnitId' => $timeUnitId
      ));

      return (int)array_pop($result)['numberOfExistingPricePlans'] === 0;
   }
} 