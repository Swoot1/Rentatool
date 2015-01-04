<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 20:48
 */

namespace Tests\ServiceTests;

use Application\Models\RentPeriod;
use Application\Services\RentPeriodService;

class RentPeriodServiceTest extends \PHPUnit_Framework_TestCase{

   public function testRead(){
      $rentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\RentPeriodMapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $rentPeriodMapperMock->expects($this->once())
                           ->method('read')
                           ->will($this->returnValue(array()));

      $rentPeriodValidationServiceMock = $this->getMockBuilder('Application\Services\RentPeriodValidationService')
                                              ->disableOriginalConstructor()
                                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock(); // TODO this should not be needed, fix

      $rentPeriodService = new RentPeriodService($rentPeriodMapperMock, $rentPeriodValidationServiceMock, $rentalObjectServiceMock);
      $rentPeriod = $rentPeriodService->read(2);

      $this->assertInstanceOf('Application\Models\RentPeriod', $rentPeriod);
   }

   public function testCreate(){

      $rentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\RentPeriodMapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $rentPeriodMapperMock->expects($this->once())
                           ->method('create')
                           ->will($this->returnArgument(0));

      $rentPeriodValidationServiceMock = $this->getMockBuilder('Application\Services\RentPeriodValidationService')
                                              ->disableOriginalConstructor()
                                              ->getMock();

      $rentPeriodValidationServiceMock->expects($this->once())
                                      ->method('checkIsValidRentPeriod')
                                      ->will($this->returnValue(true));

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->any())
                       ->method('getPricePerDay')
                       ->will($this->returnValue(100));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $rentPeriodService = new RentPeriodService($rentPeriodMapperMock, $rentPeriodValidationServiceMock, $rentalObjectServiceMock);
      $data              = array(
         'fromDate'       => '2016-11-09',
         'toDate'         => '2016-11-16',
         'rentalObjectId' => 1,
         'id'             => 1
      );

      $rentPeriod     = $rentPeriodService->create($data, $userMock);
      $rentPeriodData = $rentPeriod->toArray();

      $this->assertEquals($data['fromDate'] . ' 00:00:00', $rentPeriodData['fromDate']);
      $this->assertEquals($data['toDate'] . ' 00:00:00', $rentPeriodData['toDate']);
      $this->assertEquals(1, $rentPeriodData['renterId']);
      $this->assertEquals(800, $rentPeriodData['totalPrice']);
   }

   public function testIndex(){
      $rentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\RentPeriodMapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

      $rentPeriodMapperMock->expects($this->once())
                           ->method('index')
                           ->will($this->returnValue(array()));

      $rentPeriodValidationServiceMock = $this->getMockBuilder('Application\Services\RentPeriodValidationService')
                                              ->disableOriginalConstructor()
                                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $rentPeriodService    = new RentPeriodService($rentPeriodMapperMock, $rentPeriodValidationServiceMock, $rentalObjectServiceMock);
      $rentPeriodCollection = $rentPeriodService->index($userMock);

      $this->assertInstanceOf('Application\Collections\RentPeriodCollection', $rentPeriodCollection);
   }
} 