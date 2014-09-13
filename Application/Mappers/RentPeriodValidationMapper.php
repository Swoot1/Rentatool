<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 22:07
 */

namespace Application\Mappers;


use Application\ENFramework\Models\IDatabaseConnection;

class RentPeriodValidationMapper{
   private $databaseConnection;

   private $isAvailableRentPeriodSQL = '
      SELECT (
        SELECT
          COUNT(id)
         FROM
           rent_periods
         WHERE
           from_date <= :toDate
         AND
           to_date >= :fromDate
         AND
           rental_object_id = :rentalObjectId
        )
      AS
        "numberOfExistingRentPeriods";
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function isAvailableRentPeriod(array $data){
      $result = $this->databaseConnection->runQuery($this->isAvailableRentPeriodSQL, $data);
      $isAvailableRentPeriod = (int)array_pop($result)['numberOfExistingRentPeriods'] === 0;
      return $isAvailableRentPeriod;
   }
} 