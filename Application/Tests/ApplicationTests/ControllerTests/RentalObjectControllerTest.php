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

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock);
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

      $rentalObjectServiceController = new RentalObjectController($this->requestMock, $this->rentalObjectServiceMock, $this->responseFactoryMock);
      $response                      = $rentalObjectServiceController->read(12);
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 