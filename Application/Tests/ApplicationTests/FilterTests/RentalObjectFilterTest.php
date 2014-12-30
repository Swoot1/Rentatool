<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 11:10
 */

namespace Tests\FilterTests;


use Application\Filters\RentalObjectFilter;

class RentalObjectFilterTest extends \PHPUnit_Framework_TestCase{

   public function testGetFilterParams(){
      $rentalObjectFilter = new RentalObjectFilter(array(
                                                      'fromDate' => '2014-01-01 00:00:00',
                                                      'toDate'   => '2014-01-10 00:00:00',
                                                      'query'    => 'slipmaskin'
                                                   ));

      $filterParams = $rentalObjectFilter->getFilterParams();

      $this->assertEquals('2014-01-01 00:00:00', $filterParams['fromDate']);
      $this->assertEquals('2014-01-10 00:00:00', $filterParams['toDate']);
      $this->assertEquals('slipmaskin', $filterParams['query']);
   }

   public function testGetFilterQuery(){
      $rentalObjectFilter = new RentalObjectFilter(array(
                                                      'fromDate' => '2014-01-01 00:00:00',
                                                      'toDate'   => '2014-01-10 00:00:00',
                                                      'query'    => 'slipmaskin'
                                                   ));

      $query = 'SELECT
                  rental_objects.id,
                  user_id as "userId",
                  name,
                  price_per_day AS "pricePerDay"
               FROM rental_objects';

      $actualResult = 'SELECT
                  rental_objects.id,
                  user_id as "userId",
                  name,
                  price_per_day AS "pricePerDay"
               FROM rental_objects WHERE NOT EXISTS(
                  SELECT id
                   FROM
                     rent_periods
                  WHERE
                        rental_objects.id = rent_periods.rental_object_id
                     AND
                     (

                        (
                           :fromDate >= rent_periods.from_date
                        AND
                           :fromDate <= rent_periods.to_date
                     ) OR (
                           :toDate <= rent_periods.to_date
                        AND
                           :toDate >= rent_periods.from_date
                     ) OR (
                           :fromDate <= rent_periods.to_date
                        AND
                           :toDate >= rent_periods.from_date
                     )

                     )
                 ) AND name = :query AND active = :active';

      $query = $rentalObjectFilter->getFilterQuery($query);

      $this->assertEquals($actualResult, $query);
   }

   public function testSetter(){
      $rentalObjectFilter = new RentalObjectFilter(array('fromDate' => '2014-02-01'));
      $dbParameters       = $rentalObjectFilter->getDBParameters();
      $this->assertEquals('2014-02-01 00:00:00', $dbParameters['fromDate']);
   }
} 