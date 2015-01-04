<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 17:14
 */

namespace Tests\ServiceTests;

use Application\Services\BookingService;

class BookingServiceTest extends \PHPUnit_Framework_TestCase{

   public function testRead(){


      $bookingMapperMock = $this->getMockBuilder('Application\Mappers\BookingMapper')
                                ->disableOriginalConstructor()
                                ->getMock();

      $bookingMapperMock->expects($this->once())
                        ->method('read')
                        ->will($this->returnValue(array()));

      $bookingService = new BookingService($bookingMapperMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $booking = $bookingService->read(9, $userMock);

      $this->assertInstanceOf('Application\Models\Booking', $booking);
   }

   /**
    * The renter id is not the same as the current user id and an error will be thrown
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Du har inte rättighet att visa den här bokningsbekräftelsen.
    */
   public function testReadWithoutPermission(){

      $bookingMapperMock = $this->getMockBuilder('Application\Mappers\BookingMapper')
                                ->disableOriginalConstructor()
                                ->getMock();

      $bookingMapperMock->expects($this->once())
                        ->method('read')
                        ->will($this->returnValue(array()));

      $bookingService = new BookingService($bookingMapperMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $bookingService->read(9, $userMock);
   }

   public function index(){
      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                             ->disableOriginalConstructor()
                             ->getMock();

      $rentPeriodMock->expects($this->once())
                     ->method('getRenterId')
                     ->will($this->returnValue(2));

      $rentPeriodServiceMock->expects($this->once())
                            ->method('read')
                            ->will($this->returnValue($rentPeriodMock));

      $userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $bookingMapperMock = $this->getMockBuilder('Application\Mappers\BookingMapper')
                                ->disableOriginalConstructor()
                                ->getMock();

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $bookingService = new BookingService($rentPeriodServiceMock, $userServiceMock, $rentalObjectServiceMock, $bookingMapperMock);

      $result = $bookingService->index($userMock);

      $this->assertInstanceOf('Application\Collections\BookingCollection', $result);
   }
} 
