<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/11/14
 * Time: 21:41
 */

namespace Application\Mappers;


use Application\PHPFramework\Database\Models\IDatabaseConnection;

class ConfirmRentPeriodMapper{
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

   private $getUserFromRentPeriodSQL = '
      SELECT
          users.id,
          username,
          email,
          has_confirmed_email AS hasConfirmedEmail
       FROM
         users
       LEFT JOIN
         rent_periods
       ON
         users.id = rent_periods.renter_id
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function confirmRentPeriod($id){
      return $this->databaseConnection->runQuery($this->confirmRentPeriodSQL, array('id' => $id));
   }

   public function isRentalObjectOwner($rentPeriodId, $ownerId){
      $result = $this->databaseConnection->runQuery($this->isRentalObjectOwnerSQL, array('rentPeriodId' => $rentPeriodId, 'ownerId' => $ownerId));

      return (int)array_pop($result)['numberOfExistingRentPeriods'] > 0;
   }

   public function getUserFromRentPeriodId($id){
      $result = $this->databaseConnection->runQuery($this->getUserFromRentPeriodSQL, array('id' => $id));

      return array_shift($result);
   }
} 