<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Application\Mappers;

use Application\ENFramework\Models\IDatabaseConnection;

class RentPeriodMapper{

   private $databaseConnection;

   private $createSQL = '
      INSERT INTO
        rent_periods
        (
            renter_id,
            rental_object_id,
            from_date,
            to_date,
            price_per_day
        )
        VALUES
        (
           :renterId,
           :rentalObjectId,
           :fromDate,
           :toDate,
           :pricePerDay
        )
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $data){
      unset($data['id']);
      $this->databaseConnection->runQuery($this->createSQL, $data);
   }
} 