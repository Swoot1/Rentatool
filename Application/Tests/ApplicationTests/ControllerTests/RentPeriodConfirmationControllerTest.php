<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 01/01/15
 * Time: 09:08
 */

namespace Tests\ControllerTests;


use Application\Controllers\RentPeriodConfirmationController;
use Application\Models\User;

class RentPeriodConfirmationControllerTest extends \PHPUnit_Framework_TestCase{
   public function testRead(){
      $rentPeriodConfirmationServiceMock = $this->getMockBuilder('Application\Services\RentPeriodConfirmationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentPeriodConfirmationMock = $this->getMockBuilder('Application\Models\RentPeriodConfirmation')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentPeriodConfirmationServiceMock->expects($this->once())
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

      $rentPeriodConfirmationController = new RentPeriodConfirmationController($rentPeriodConfirmationServiceMock, $responseFactoryMock, $sessionManagerMock);

      $result = $rentPeriodConfirmationController->read(1);

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $result);
   }
} 