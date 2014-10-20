<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 18:36
 */

namespace Tests\ControllerTests;


use Application\Controllers\RentPeriodController;

class RentPeriodControllerTest extends \PHPUnit_Framework_TestCase{

   private $rentPeriodServiceMock;
   private $responseFactoryMock;
   private $sessionManagerMock;

   public function setUp(){
      $this->rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                          ->disableOriginalConstructor()
                                          ->getMock();

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->sessionManagerMock = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                       ->disableOriginalConstructor()
                                       ->getMock();

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $this->sessionManagerMock->expects($this->any())->method('getCurrentUser')
                               ->will($this->returnValue($userMock));
   }

   public function testCreate(){


      $rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                               ->disableOriginalConstructor()
                               ->getMock();

      $this->rentPeriodServiceMock->expects($this->once())
                                  ->method('create')
                                  ->will($this->returnValue($rentPeriodMock));

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseMock->expects($this->once())
                   ->method('setStatusCode')
                   ->will($this->returnValue($responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($responseMock));

      $rentalObjectServiceController = new RentPeriodController($this->rentPeriodServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);

   }

   public function testGetCalculatedPricePlan(){
      $rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                               ->disableOriginalConstructor()
                               ->getMock();

      $this->rentPeriodServiceMock->expects($this->once())
                                  ->method('getCalculatedPricePlan')
                                  ->will($this->returnValue($rentPeriodMock));

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseMock->expects($this->once())
                   ->method('setStatusCode')
                   ->will($this->returnValue($responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($responseMock));

      $rentalObjectServiceController = new RentPeriodController($this->rentPeriodServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->getCalculatedRentPeriod(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 