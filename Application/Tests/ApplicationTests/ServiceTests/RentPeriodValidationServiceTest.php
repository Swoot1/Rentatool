<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 19:40
 */

namespace Tests\ServiceTests;


use Application\Services\RentPeriodValidationService;

class RentPeriodValidationServiceTest extends \PHPUnit_Framework_TestCase{

   private $rentPeriodMock;

   public function setUp(){
      $this->rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $this->rentPeriodMock->expects($this->once())
                           ->method('getRentalObjectId')
                           ->will($this->returnValue(1));

      $this->rentPeriodMock->expects($this->once())
                           ->method('getFromDate')
                           ->will($this->returnValue('2014-03-15'));

      $this->rentPeriodMock->expects($this->once())
                           ->method('getToDate')
                           ->will($this->returnValue('2014-01-01'));
   }

   public function testCheckIsValidRentPeriod(){

      $rentPeriodValidationMapperMock = $this->getMockBuilder('Application\Mappers\RentPeriodValidationMapper')
                                             ->disableOriginalConstructor()
                                             ->getMock();

      $rentPeriodValidationMapperMock->expects($this->once())
                                     ->method('isAvailableRentPeriod')
                                     ->will($this->returnValue(true));


      $rentPeriodValidationService = new RentPeriodValidationService($rentPeriodValidationMapperMock);

      $this->assertTrue($rentPeriodValidationService->checkIsValidRentPeriod($this->rentPeriodMock));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Objektet är inte tillgängligt under vald period.
    */
   public function testCheckIsInvalidRentPeriod(){

      $rentPeriodValidationMapperMock = $this->getMockBuilder('Application\Mappers\RentPeriodValidationMapper')
                                             ->disableOriginalConstructor()
                                             ->getMock();

      $rentPeriodValidationMapperMock->expects($this->once())
                                     ->method('isAvailableRentPeriod')
                                     ->will($this->returnValue(false));


      $rentPeriodValidationService = new RentPeriodValidationService($rentPeriodValidationMapperMock);

      $rentPeriodValidationService->checkIsValidRentPeriod($this->rentPeriodMock);
   }
}