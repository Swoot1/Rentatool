<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 14:59
 */

namespace Tests\ControllerTests;


use Application\Controllers\DatabaseController;

class DatabaseControllerTest extends \PHPUnit_Framework_TestCase{

   private $databaseServiceMock;
   private $responseFactoryMock;
   private $responseMock;

   public function setUp(){
      $this->databaseServiceMock = $this->getMockBuilder('Application\Services\DatabaseService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->responseFactoryMock = $this->getMockBuilder('Application\PHPFramework\Response\Factories\ResponseFactory')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->responseMock = $this->getMockBuilder('Application\PHPFramework\Response\Response')
                                 ->disableOriginalConstructor()
                                 ->getMock();
   }

   public function testCreate(){

      $this->databaseServiceMock->expects($this->once())
                                ->method('create');

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $databaseController = new DatabaseController($this->databaseServiceMock, $this->responseFactoryMock);
      $response           = $databaseController->create();
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

   public function testCreateWithSeeds(){
      $this->databaseServiceMock->expects($this->once())
                                ->method('createWithSeeds');

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('addNotifier');

      $databaseController = new DatabaseController($this->databaseServiceMock, $this->responseFactoryMock);
      $response           = $databaseController->createWithSeeds();
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 