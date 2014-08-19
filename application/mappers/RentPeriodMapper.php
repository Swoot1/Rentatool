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
        rent_period
        (
            renter_id,
            rental_object_id,
            from_date,
            to_date
        )
        VALUES
        (
           :renterId,
           :rentalObjectId,
           :fromDate,
           :toDate
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