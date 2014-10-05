<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 15:13
 */

namespace Tests\ControllerTests;


use Application\Controllers\FileController;

class FileControllerTest extends \PHPUnit_Framework_TestCase{

   private $fileServiceMock;
   private $responseFactoryMock;
   private $responseMock;

   public function setUp(){
      $this->fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
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

      $fileMock = $this->getMockBuilder('Application\Models\File')
                       ->disableOriginalConstructor()
                       ->getMock();

      $this->fileServiceMock->expects($this->once())
                            ->method('create')
                            ->will($this->returnValue($fileMock));

      $this->responseMock->expects($this->once())
                         ->method('setStatusCode')
                         ->will($this->returnValue($this->responseMock));

      $this->responseMock->expects($this->once())
                         ->method('setResponseData')
                         ->will($this->returnValue($this->responseMock));

      $this->responseFactoryMock->expects($this->once())
                                ->method('build')
                                ->will($this->returnValue($this->responseMock));


      $fileController = new FileController($this->fileServiceMock, $this->responseFactoryMock);
      $response       = $fileController->create(array());
      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }
} 