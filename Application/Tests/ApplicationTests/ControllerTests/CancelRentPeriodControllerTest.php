<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/01/15
 * Time: 09:54
 */

namespace Tests\ControllerTests;


use Application\Controllers\CancelRentPeriodController;

class CancelRentPeriodControllerTest extends \PHPUnit_Framework_TestCase{
   public function testUpdate(){
      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                             ->disableOriginalConstructor()
                             ->getMock();

      $rentPeriodServiceMock->expects($this->once())
                            ->method('cancelRentPeriod')
                            ->will($this->returnValue($rentPeriodMock));

      $responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                  ->disableOriginalConstructor()
                                  ->getMock();

      $responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                           ->disableOriginalConstructor()
                           ->getMock();

      $responseMock->expects($this->once())
                   ->method('addNotifier')
                   ->will($this->returnValue($responseMock));

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

      $cancelRentPeriodController = new CancelRentPeriodController($rentPeriodServiceMock, $responseFactoryMock, $sessionManagerMock);

      $cancelRentPeriodController->update(1);

   }
} 