<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 16:37
 */

namespace Tests\ControllerTests;

use Application\Controllers\SignUpController;

class UserControllerTest extends \PHPUnit_Framework_TestCase{
   private $userServiceMock;
   private $responseFactoryMock;
   private $responseMock;
   private $sessionManager;

   public function setUp(){
      $this->userServiceMock = $this->getMockBuilder('Application\Services\Userservice')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $this->sessionManager = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                 ->disableOriginalConstructor()
                                 ->getMock();
   }


   public function testCreate(){

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $this->userServiceMock->expects($this->once())
                            ->method('signUp')
                            ->will($this->returnValue($userMock));

      $this->responseMock->expects($this->once())
                         ->method('setStatusCode')
                         ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('addNotifier')
                         ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));


      $userController = new SignUpController($this->userServiceMock, $this->responseFactoryMock, $this->sessionManager);
      $response       = $userController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 