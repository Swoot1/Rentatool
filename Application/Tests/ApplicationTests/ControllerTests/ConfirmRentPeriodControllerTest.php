<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/11/14
 * Time: 17:16
 */

namespace Tests\ControllerTests;


use Application\Controllers\ConfirmRentPeriodController;

class ConfirmRentPeriodControllerTest extends \PHPUnit_Framework_TestCase{

   public function testConfirmRentPeriod(){

      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodServiceMock->expects($this->once())
                            ->method('confirmRentPeriod')
                            ->will($this->returnValue(true)); // TODO return value

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

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

      $confirmRentPeriodController = new ConfirmRentPeriodController($rentPeriodServiceMock, $responseFactoryMock, $sessionManagerMock);

      $response = $confirmRentPeriodController->update(2, array());

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 