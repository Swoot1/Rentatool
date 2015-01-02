<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 17:14
 */

namespace Tests\ServiceTests;


use Application\Models\RentPeriod;
use Application\Models\BookingDetails;
use Application\Services\BookingService;

class BookingServiceTest extends \PHPUnit_Framework_TestCase{

   public function testRead(){

      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodServiceMock->expects($this->once())
                            ->method('read')
                            ->will($this->returnValue(new RentPeriod(array())));

      $userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('getUserId')
                       ->will($this->returnValue(1));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $bookingMapperMock = $this->getMockBuilder('Application\Mappers\BookingMapper')
                                ->disableOriginalConstructor()
                                ->getMock();

      $bookingService = new BookingService($rentPeriodServiceMock, $userServiceMock, $rentalObjectServiceMock, $bookingMapperMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userServiceMock->expects($this->once())
                      ->method('read')
                      ->will($this->returnValue($userMock));

      $bookingDetailsFactoryMock= $this->getMockBuilder('Application\Factories\BookingDetailsFactory')
                                                ->disableOriginalConstructor()
                                                ->getMock();
      $bookingDetailsFactoryMock->expects($this->once())
                                        ->method('getBookingDetails')
                                        ->will($this->returnValue(new BookingDetails(array())));

      $booking = $bookingService->read(9, $userMock, $bookingDetailsFactoryMock);

      $this->assertInstanceOf('Application\Models\BookingDetails', $booking);
   }

   /**
    * The renter id is not the same as the current user id and an error will be thrown
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Du har inte rättighet att visa den här bokningsbekräftelsen.
    */
   public function testReadWithoutPermission(){

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

      $bookingService = new BookingService($rentPeriodServiceMock, $userServiceMock, $rentalObjectServiceMock, $bookingMapperMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $bookingDetailsFactoryMock = $this->getMockBuilder('Application\Factories\BookingDetailsFactory')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $bookingService->read(9, $userMock, $bookingDetailsFactoryMock);
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
