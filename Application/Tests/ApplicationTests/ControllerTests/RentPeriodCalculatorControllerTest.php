<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 15:32
 */

namespace Tests\ControllerTests;


use Application\Controllers\RentPeriodCalculatorController;

class RentPeriodCalculatorControllerTest extends \PHPUnit_Framework_TestCase{
   public function testCreate(){
      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $sessionManagerMock = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $sessionManagerMock->expects($this->any())->method('getCurrentUser')
                         ->will($this->returnValue($userMock));

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentPeriod')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentPeriodServiceMock->expects($this->once())
                            ->method('getCalculatedPricePlan')
                            ->will($this->returnValue($rentalObjectMock));

      $responseMock->expects($this->once())
                   ->method('setResponseData')
                   ->will($this->returnValue($responseMock));

      $responseMock->expects($this->once())
                   ->method('setStatusCode')
                   ->will($this->returnValue($responseMock));

      $responseFactoryMock->expects($this->once())
                          ->method('build')
                          ->will($this->returnValue($responseMock));

      $rentalObjectServiceController = new RentPeriodCalculatorController($rentPeriodServiceMock, $responseFactoryMock, $sessionManagerMock);
      $response                      = $rentalObjectServiceController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
}