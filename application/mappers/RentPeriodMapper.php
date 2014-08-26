<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

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
            price
        )
        VALUES
        (
           :renterId,
           :rentalObjectId,
           :fromDate,
           :toDate,
           :price
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