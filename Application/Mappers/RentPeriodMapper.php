<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Application\Mappers;

use Application\PHPFramework\Database\Models\IDatabaseConnection;

class RentPeriodMapper{

   private $databaseConnection;


   private $readSQL = '
      SELECT
         id,
         renter_id AS renterId,
         rental_object_id AS rentalObjectId,
         from_date AS fromDate,
         to_date AS toDate,
         price_per_day AS pricePerDay
      FROM
        rent_periods
      WHERE
         id = :id
   ';

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

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));

      return array_shift($result);
   }

   public function create(array $data){
      unset($data['id']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $data);

      return $this->read($result['lastInsertId']);
   }
} 