<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 25/08/14
 * Time: 21:56
 */

namespace Tests\ModelTests;


use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\Models\RentPeriod;
use Rentatool\Application\Models\RentPeriodPriceCalculator;

class RentPeriodTest extends \PHPUnit_Framework_TestCase{
   public function testSetPricePlanCollectionWithDay(){

      $rentPeriod = new RentPeriod(array(
                                      'fromDate' => '2014-06-01 00:00:00',
                                      'toDate'   => '2014-06-05 00:00:00'
                                   ), new RentPeriodPriceCalculator());

      $pricePlanCollection = new PricePlanCollection(array(array('timeUnitId' => 2, 'price' => 50)));
      $rentPeriod->setPricePlanCollection($pricePlanCollection);

      $DBParameters = $rentPeriod->getDBParameters();
      $this->assertEquals(200, $DBParameters['price']);
   }

   public function testSetPricePlanCollectionWithMonths(){

      $rentPeriod = new RentPeriod(array(
                                      'fromDate' => '2014-06-01 00:00:00',
                                      'toDate'   => '2014-10-01 00:00:00'
                                   ), new RentPeriodPriceCalculator());

      $pricePlanCollection = new PricePlanCollection(array(array('timeUnitId' => 3, 'price' => 1000)));
      $rentPeriod->setPricePlanCollection($pricePlanCollection);

      $DBParameters = $rentPeriod->getDBParameters();
      $this->assertEquals(4000, $DBParameters['price']);
   }

   public function testSetPricePlanCollectionWithYear(){

      $rentPeriod = new RentPeriod(array(
                                      'fromDate' => '2013-06-01 00:00:00',
                                      'toDate'   => '2018-06-01 00:00:00'
                                   ), new RentPeriodPriceCalculator());

      $pricePlanCollection = new PricePlanCollection(array(array('timeUnitId' => 3, 'price' => 100), array('timeUnitId' => 4, 'price' => 500.50)));
      $rentPeriod->setPricePlanCollection($pricePlanCollection);

      $DBParameters = $rentPeriod->getDBParameters();
      $this->assertEquals(2502.5, $DBParameters['price']);
   }

   public function testSetPricePlanCollectionWithHours(){

      $rentPeriod = new RentPeriod(array(
                                      'fromDate' => '2013-06-01 00:00:00',
                                      'toDate'   => '2013-06-02 02:00:00'
                                   ), new RentPeriodPriceCalculator());

      $pricePlanCollection = new PricePlanCollection(array(array('timeUnitId' => 1, 'price' => 100), array('timeUnitId' => 4, 'price' => 500.50)));
      $rentPeriod->setPricePlanCollection($pricePlanCollection);

      $DBParameters = $rentPeriod->getDBParameters();
      $this->assertEquals(2600, $DBParameters['price']);
   }

   public function testSetPricePlanCollectionWithWeeks(){

      $rentPeriod = new RentPeriod(array(
                                      'fromDate' => '2014-08-25 00:00:00',
                                      'toDate'   => '2014-09-29 00:00:00'
                                   ), new RentPeriodPriceCalculator());

      $pricePlanCollection = new PricePlanCollection(array(array('timeUnitId' => 3, 'price' => 500), array('timeUnitId' => 4, 'price' => 500.50)));
      $rentPeriod->setPricePlanCollection($pricePlanCollection);

      $DBParameters = $rentPeriod->getDBParameters();
      $this->assertEquals(2500, $DBParameters['price']);
   }
} 