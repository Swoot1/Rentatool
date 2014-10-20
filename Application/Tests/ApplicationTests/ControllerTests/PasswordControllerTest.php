<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 15:58
 */

namespace Tests\ControllerTests;


use Application\Controllers\PasswordController;

class PasswordControllerTest extends \PHPUnit_Framework_TestCase{
   public function testCreate(){

      $passwordServiceMock = $this->getMockBuilder('Application\Services\PasswordService')
                                  ->disableOriginalConstructor()
                                  ->getMock();

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


      $requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                           ->disableOriginalConstructor()
                           ->getMock();

      $requestMock->expects($this->once())
                             ->method('getGETParameters')
                             ->will($this->returnValue(['resetCode' => '5442ad085370f']));

      $passwordController = new PasswordController($requestMock, $passwordServiceMock, $responseFactoryMock);
      $response           = $passwordController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 