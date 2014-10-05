<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 15:50
 */

namespace Tests\ControllerTests;


use Application\Collections\MenuItemCollection;
use Application\Controllers\MenuController;

class MenuControllerTest extends \PHPUnit_Framework_TestCase{

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
      $menuServiceMock = $this->getMockBuilder('Application\Services\MenuService')
                              ->disableOriginalConstructor()
                              ->getMock();


      $menuServiceMock->expects($this->once())
                      ->method('index')
                      ->will($this->returnValue(new MenuItemCollection()));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $menuController = new MenuController($this->responseFactoryMock, $menuServiceMock);

      $response = $menuController->index();

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 