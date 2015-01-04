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
         renter_id AS "renterId",
         rental_object_id AS "rentalObjectId",
         from_date AS "fromDate",
         to_date AS "toDate",
         price_per_day AS "pricePerDay",
         total_price AS "totalPrice",
         cancelled
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
            price_per_day,
            total_price,
            cancelled
        )
        VALUES
        (
           :renterId,
           :rentalObjectId,
           :fromDate,
           :toDate,
           :pricePerDay,
           :totalPrice,
           :cancelled
        )
   ';

   private $indexSQL = '
    SELECT
         rent_periods.id,
         rent_periods.renter_id AS "renterId",
         rent_periods.rental_object_id AS "rentalObjectId",
         rent_periods.from_date AS "fromDate",
         rent_periods.to_date AS "toDate",
         rent_periods.price_per_day AS "pricePerDay",
         rent_periods.total_price AS "totalPrice",
         cancelled
      FROM
        rent_periods
      LEFT JOIN
        rental_objects
        ON
        rental_objects.id = rent_periods.rental_object_id
      WHERE
         renter_id = :userId
   ';

   private $cancelRentPeriodSQL = '
      UPDATE
         rent_periods
      SET
        cancelled = 1
      WHERE
        id = :id
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

   public function index(array $data){
      return $this->databaseConnection->runQuery($this->indexSQL, $data);
   }

   public function cancelRentPeriod($id){
      $this->databaseConnection->runQuery($this->cancelRentPeriodSQL, array('id' => $id));
   }
} 