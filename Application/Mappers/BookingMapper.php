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
         owners.username AS "rentalObjectOwnerName",
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

   // TODO ? Byta namn på user_id fältet på rental_object till owner_id?

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function index(User $currentUser){
      return $this->databaseConnection->runQuery($this->indexSQL, array('currentUser' => $currentUser->getId()));
   }
} 