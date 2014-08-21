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
        price_plan
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
        price_plan
      WHERE
         rental_object_id = :rentalObjectId
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $data){
      unset($data['id']);
      return $this->databaseConnection->runQuery($this->createSQL, $data);
   }

   public function readCollectionFromRentalObjectId($rentalObjectId){
      return $this->databaseConnection->runQuery($this->readCollectionFromRentalObjectIdSQL,
                                          array('rentalObjectId' => $rentalObjectId));
   }
} 