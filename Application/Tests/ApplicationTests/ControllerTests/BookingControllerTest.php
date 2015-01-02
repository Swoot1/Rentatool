<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 01/01/15
 * Time: 09:08
 */

namespace Tests\ControllerTests;

use Application\Controllers\BookingController;

class BookingControllerTest extends \PHPUnit_Framework_TestCase{
   public function testRead(){
      $bookingServiceMock = $this->getMockBuilder('Application\Services\BookingService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentPeriodConfirmationMock = $this->getMockBuilder('Application\Models\RentPeriodConfirmation')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $bookingServiceMock->expects($this->once())
                                        ->method('read')
                                        ->will($this->returnValue($rentPeriodConfirmationMock));

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseFactoryMock->expects($this->once())
                          ->method('build')
                          ->will($this->returnValue($responseMock));

      $sessionManagerMock = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $sessionManagerMock->expects($this->once())
                         ->method('getCurrentUser')
                         ->will($this->returnValue($userMock));

      $bookingController = new BookingController($bookingServiceMock, $responseFactoryMock, $sessionManagerMock);

      $result = $bookingController->read(1);

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $result);
   }

   public function testIndex(){
      $bookingServiceMock = $this->getMockBuilder('Application\Services\BookingService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentPeriodConfirmationCollectionMock = $this->getMockBuilder('Application\Collections\RentPeriodConfirmationCollection')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $bookingServiceMock->expects($this->once())
                                        ->method('index')
                                        ->will($this->returnValue($rentPeriodConfirmationCollectionMock));

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseFactoryMock->expects($this->once())
                          ->method('build')
                          ->will($this->returnValue($responseMock));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $sessionManagerMock = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $sessionManagerMock->expects($this->once())
                         ->method('getCurrentUser')
                         ->will($this->returnValue($userMock));

      $bookingController = new BookingController($bookingServiceMock, $responseFactoryMock, $sessionManagerMock);

      $result = $bookingController->index();

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $result);
   }
} 