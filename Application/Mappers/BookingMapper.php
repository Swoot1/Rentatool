<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/01/15
 * Time: 17:46
 */

namespace Application\Mappers;


use Application\Models\User;
use Application\PHPFramework\Database\Models\IDatabaseConnection;

class BookingMapper{
   private $databaseConnection;

   private $indexSQL = '
      SELECT
         rent_periods.id AS "rentPeriodId",
         rent_periods.from_date AS "fromDate",
         rent_periods.to_date AS "toDate",
         rent_periods.renter_id AS "renterId",
         rent_periods.total_price AS "totalPrice",
         rent_periods.cancelled,
         owners.username AS "rentalObjectOwnerName",
         owners.phone_number AS "phoneNumber",
         owners.address,
         owners.additional_address_information AS "additionalAddressInformation",
         owners.zip_code AS "zipCode",
         owners.city,
         owners.email,
         rental_objects.name AS "rentalObjectName"
      FROM
        rent_periods
      LEFT JOIN
        rental_objects
      ON
        rental_objects.id = rent_periods.rental_object_id
      LEFT JOIN
        users as owners
      ON
        rental_objects.user_id = owners.id
      WHERE
        rent_periods.renter_id  = :currentUser
   ';

   private $readSQL = '
   SELECT
         rent_periods.id AS "rentPeriodId",
         rent_periods.from_date AS "fromDate",
         rent_periods.to_date AS "toDate",
         rent_periods.renter_id AS "renterId",
         rent_periods.total_price AS "totalPrice",
         rent_periods.cancelled,
         owners.username AS "rentalObjectOwnerName",
         owners.phone_number AS "phoneNumber",
         owners.address,
         owners.additional_address_information AS "additionalAddressInformation",
         owners.zip_code AS "zipCode",
         owners.city,
         owners.email,
         rental_objects.name AS "rentalObjectName"
      FROM
        rent_periods
      LEFT JOIN
        rental_objects
      ON
        rental_objects.id = rent_periods.rental_object_id
      LEFT JOIN
        users as owners
      ON
        rental_objects.user_id = owners.id
      WHERE
        rent_periods.id = :rentPeriodId
   ';

   // TODO ? Byta namn på user_id fältet på rental_object till owner_id?

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function index(User $currentUser){
      return $this->databaseConnection->runQuery($this->indexSQL, array('currentUser' => $currentUser->getId()));
   }

   public function read($rentPeriodId){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('rentPeriodId' => $rentPeriodId));

      return array_shift($result);
   }
} 