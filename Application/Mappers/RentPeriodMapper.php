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
         is_confirmed_by_owner AS "isConfirmedByOwner"
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
            is_confirmed_by_owner
        )
        VALUES
        (
           :renterId,
           :rentalObjectId,
           :fromDate,
           :toDate,
           :pricePerDay,
           :isConfirmedByOwner
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
         rent_periods.is_confirmed_by_owner AS "isConfirmedByOwner"
      FROM
        rent_periods
      LEFT JOIN
        rental_objects
        ON
        rental_objects.id = rent_periods.rental_object_id
      WHERE
         rental_objects.user_id = :userId
   ';

   private $confirmRentPeriodSQL = '
      UPDATE
         rent_periods
      SET
        is_confirmed_by_owner = true
      WHERE
        id = :id
   ';


   private $isRentalObjectOwnerSQL = '
      SELECT (
           SELECT
             COUNT(rent_periods.id)
            FROM
              rent_periods
            LEFT JOIN
              rental_objects
            ON
              rent_periods.rental_object_id = rental_objects.id
            WHERE
                rental_objects.user_id = :ownerId
              AND
                rent_periods.id = :rentPeriodId
           )
         AS
           "numberOfExistingRentPeriods";
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

   public function confirmRentPeriod($id){
      return $this->databaseConnection->runQuery($this->confirmRentPeriodSQL, array('id' => $id));
   }

   public function isRentalObjectOwner($rentPeriodId, $ownerId){
      $result = $this->databaseConnection->runQuery($this->isRentalObjectOwnerSQL, array('rentPeriodId' => $rentPeriodId, 'ownerId' => $ownerId));

      return (int)array_pop($result)['numberOfExistingRentPeriods'] > 0;
   }
} 