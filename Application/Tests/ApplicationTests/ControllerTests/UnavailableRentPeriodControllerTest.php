<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 16:26
 */

namespace Tests\ControllerTests;


use Application\Collections\UnavailableRentPeriodCollection;
use Application\Controllers\UnavailableRentPeriodController;

class UnavailableRentPeriodTest extends \PHPUnit_Framework_TestCase{

   public function testIndex(){

      $requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                          ->disableOriginalConstructor()
                          ->getMock();

      $requestMock->expects($this->once())
                  ->method('getGETParameters')
                  ->will($this->returnValue(array('rentalObjectId' => 1)));

      $unavailableRentPeriodServiceMock = $this->getMockBuilder('Application\Services\UnavailableRentPeriodService')
                                               ->disableOriginalConstructor()
                                               ->getMock();

      $unavailableRentPeriodServiceMock->expects($this->once())
                                       ->method('index')
                                       ->will($this->returnValue(new UnavailableRentPeriodCollection()));

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseFactoryMock->expects($this->once())
                          ->method('build')
                          ->will($this->returnValue($responseMock));

      $unavailableRentPeriodController = new UnavailableRentPeriodController($requestMock,
                                                                             $unavailableRentPeriodServiceMock,
                                                                             $responseFactoryMock);
      $response                        = $unavailableRentPeriodController->index();
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 