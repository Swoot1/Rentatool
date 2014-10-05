<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 11:36
 */

namespace Tests\FilterTests;


use Application\Filters\UnavailableRentPeriodFilter;

class UnavailableRentPeriodFilterTest extends \PHPUnit_Framework_TestCase{

   public function testGetFilterParams(){
      $unavailableRentPeriodFilter = new UnavailableRentPeriodFilter(array(
                                                                        'rentalObjectId'      => 14,
                                                                        'nonExistingProperty' => 'test'
                                                                     ));

      $filterParams = $unavailableRentPeriodFilter->getFilterParams();

      $this->assertEquals(14, $filterParams['rentalObjectId']);
      $this->assertFalse(array_key_exists('nonExistingProperty', $filterParams));
   }

   public function testGetFilterQuery(){
      $unavailableRentPeriodFilter = new UnavailableRentPeriodFilter(array(
                                                                        'rentalObjectId'      => 14,
                                                                        'nonExistingProperty' => 'test'
                                                                     ));
      $query                       = ' SELECT
                     id,
                     rental_object_id AS "rentalObjectId",
                     from_date AS "fromDate",
                     to_date AS "toDate"
                  FROM
                    rent_periods';

      $query       = $unavailableRentPeriodFilter->getFilterQuery($query);
      $actualQuery = ' SELECT
                     id,
                     rental_object_id AS "rentalObjectId",
                     from_date AS "fromDate",
                     to_date AS "toDate"
                  FROM
                    rent_periods WHERE rental_object_id = :rentalObjectId';

      $this->assertEquals($actualQuery, $query);
   }
} 