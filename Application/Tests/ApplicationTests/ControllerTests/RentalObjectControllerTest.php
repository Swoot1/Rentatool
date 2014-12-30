<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 16:08
 */

namespace Tests\ControllerTests;


use Application\Controllers\RentalObjectController;

class RentalObjectControllerTest extends \PHPUnit_Framework_TestCase{

   private $rentalObjectServiceMock;
   private $responseFactoryMock;
   private $responseMock;
   private $requestMock;
   private $sessionManagerMock;

   public function setUp(){
      $this->rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                            ->disableOriginalConstructor()
                                            ->getMock();

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $this->requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
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

   public function testIndex(){

      $rentalObject = $this->getMockBuilder('Application\Models\RentalObject')
                           ->disableOriginalConstructor()
                           ->getMock();

      $this->rentalObjectServiceMock->expects($this->once())
                                    ->method('index')
                                    ->will($this->returnValue($rentalObject));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $this->requestMock->expects($this->once())
                        ->method('getGETParameters')
                        ->will($this->returnValue(array()));

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->index(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

   public function testRead(){

      $rentalObject = $this->getMockBuilder('Application\Models\RentalObject')
                           ->disableOriginalConstructor()
                           ->getMock();

      $this->rentalObjectServiceMock->expects($this->once())
                                    ->method('read')
                                    ->will($this->returnValue($rentalObject));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->read(12);
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

   public function testCreate(){
      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $this->rentalObjectServiceMock->expects($this->once())
                                    ->method('create')
                                    ->will($this->returnValue($rentalObjectMock));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('setStatusCode')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

   public function testUpdate(){
      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $this->rentalObjectServiceMock->expects($this->once())
                                    ->method('update')
                                    ->will($this->returnValue($rentalObjectMock));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock, $this->sessionManagerMock);
      $response                      = $rentalObjectServiceController->update(1, array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 