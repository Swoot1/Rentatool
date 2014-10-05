<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 15:35
 */

namespace Tests\ControllerTests;


use Application\Controllers\IndexHTMLController;

class IndexHTMLControllerTest extends \PHPUnit_Framework_TestCase{

   private $responseFactoryMock;
   private $responseMock;

   public function setUp(){

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                                 ->disableOriginalConstructor()
                                 ->getMock();
   }

   public function testIndex(){

      $this->responseMock->expects($this->once())
                         ->method('setContentType')
                         ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $indexHTMLController = new IndexHTMLController($this->responseFactoryMock);
      $response            = $indexHTMLController->index();

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 