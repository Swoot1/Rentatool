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

      $confirmRentPeriodServiceMock = $this->getMockBuilder('Application\Services\ConfirmRentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $confirmRentPeriodServiceMock->expects($this->once())
                            ->method('confirmRentPeriod');

      $confirmRentPeriodServiceMock->expects($this->once())
                            ->method('sendRentPeriodConfirmation');

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                          ->method('addNotifier')
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

      $confirmRentPeriodController = new ConfirmRentPeriodController($confirmRentPeriodServiceMock, $responseFactoryMock, $sessionManagerMock);

      $response = $confirmRentPeriodController->update(2, array());

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 