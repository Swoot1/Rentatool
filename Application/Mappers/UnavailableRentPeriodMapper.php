<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:22
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\IDatabaseConnection;
use Rentatool\Application\Filters\UnavailableRentPeriodFilter;

class UnavailableRentPeriodMapper{

   private $databaseConnection;

   private $indexSQL = '
      SELECT
         id,
         rental_object_id AS "rentalObjectId",
         from_date AS "fromDate",
         to_date AS "toDate"
      FROM
        rent_periods
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function index(UnavailableRentPeriodFilter $unavailableRentPeriodFilter){
      $query = $unavailableRentPeriodFilter->getFilterQuery($this->indexSQL);

      return $this->databaseConnection->runQuery($query, $unavailableRentPeriodFilter->getFilterParams());
   }
} 