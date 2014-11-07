<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/10/14
 * Time: 13:26
 */

namespace Tests\ModelTests;


use Application\Models\RentPeriod;

class RentPeriodTest extends \PHPUnit_Framework_TestCase{


   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Från-och-med-datum måste komma före till-och-med-datum.
    */
   public function testFromDateIsBeforeToDate(){
      new RentPeriod(array(
                        'fromDate' => '2016-01-18',
                        'toDate'   => '2015-02-20'
                     ));
   }

   /**
    * This should not cast an exception
    */
   public function testFromDateIsEqualToToDate(){
      new RentPeriod(array(
                        'fromDate' => '2016-01-18',
                        'toDate'   => '2016-01-18'
                     ));

      $this->assertTrue(true);
   }
} 