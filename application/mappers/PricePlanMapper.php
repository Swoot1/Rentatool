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

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $data){
      unset($data['id']);
      return $this->databaseConnection->runQuery($this->createSQL, $data);
   }
} 