<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 14:38
 */

namespace Tests\ControllerTests;


use Application\Controllers\AuthorizationController;

class AuthorizationControllerTest extends \PHPUnit_Framework_TestCase{


   private $authorizationServiceMock;
   private $responseFactoryMock;
   private $authorizationMock;
   private $responseMock;

   public function setUp(){
      $this->authorizationServiceMock = $this->getMockBuilder('Application\Services\AuthorizationService')
                                             ->disableOriginalConstructor()
                                             ->getMock();

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->authorizationMock = $this->getMockBuilder('Application\Models\Authorization')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $this->responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                                 ->disableOriginalConstructor()
                                 ->getMock();
   }

   public function testLogin(){

      $this->authorizationServiceMock->expects($this->once())
                                     ->method('login')
                                     ->will($this->returnValue($this->authorizationMock));


      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $authorizationController = new AuthorizationController($this->authorizationServiceMock, $this->responseFactoryMock);

      $response = $authorizationController->login(array());

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

   public function testLogout(){
      $this->authorizationServiceMock->expects($this->once())
                                     ->method('logout')
                                     ->will($this->returnValue($this->authorizationMock));


      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $authorizationController = new AuthorizationController($this->authorizationServiceMock, $this->responseFactoryMock);

      $response = $authorizationController->logout(array());

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);

   }
} 