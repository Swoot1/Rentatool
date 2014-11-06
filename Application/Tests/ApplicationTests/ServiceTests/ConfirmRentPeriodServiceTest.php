<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 06/11/14
 * Time: 15:33
 */

namespace Tests\ServiceTests;


use Application\Services\ConfirmRentPeriodService;

class ConfirmRentPeriodServiceTest extends \PHPUnit_Framework_TestCase{
   public function testConfirmRentPeriod(){

      $confirmRentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\ConfirmRentPeriodMapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $confirmRentPeriodMapperMock->expects($this->once())
                           ->method('confirmRentPeriod')
                           ->will($this->returnValue(array()));

      $confirmRentPeriodMapperMock->expects($this->once())
                           ->method('isRentalObjectOwner')
                           ->will($this->returnValue(true));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $confirmRentPeriodService = new ConfirmRentPeriodService($confirmRentPeriodMapperMock);
      $result            = $confirmRentPeriodService->confirmRentPeriod(1, $userMock);

      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Kan inte godkänna uthyrningsperioder vars uthyrningsobjekt du inte är ägare av.
    */
   public function testConfirmRentPeriodIsNotOwner(){

      $confirmRentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\ConfirmRentPeriodMapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $confirmRentPeriodMapperMock->expects($this->once())
                           ->method('isRentalObjectOwner')
                           ->will($this->returnValue(false));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $confirmRentPeriodService = new ConfirmRentPeriodService($confirmRentPeriodMapperMock);
      $confirmRentPeriodService->confirmRentPeriod(1, $userMock);
   }
} 