<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 18:59
 */

namespace Tests\PHPFrameworkTests\RequestTests;


use Application\PHPFramework\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase{

   public function testUpdate(){
      $request = new Request(array(
                                'requestMethod' => 'PUT',
                                'requestData'   => array(),
                                'resource'      => 'rentalObjects',
                                'contentType'   => 'application/json',
                                'id'            => 3332
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('update');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange ett id för uppdatering.
    */
   public function testUpdateWithoutId(){
      $request = new Request(array(
                                'requestMethod' => 'PUT',
                                'requestData'   => array(),
                                'resource'      => 'rentalObjects',
                                'contentType'   => 'application/json'
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   public function testRead(){
      $request = new Request(array(
                                'requestMethod' => 'GET',
                                'requestData'   => array(),
                                'resource'      => 'rentalObjects',
                                'contentType'   => 'application/json',
                                'id'            => 3332
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('read');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   public function testIndex(){
      $request = new Request(array(
                                'requestMethod' => 'GET',
                                'requestData'   => array(),
                                'resource'      => 'rentalObjects',
                                'contentType'   => 'application/json'
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('index');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   public function testReadWithAction(){
      $request = new Request(array(
                                'requestMethod' => 'GET',
                                'requestData'   => array(),
                                'resource'      => 'authorization',
                                'contentType'   => 'application/json',
                                'action'        => 'login'
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\AuthorizationController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('login');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   public function testDelete(){
      $request = new Request(array(
                                'requestMethod' => 'DELETE',
                                'requestData'   => array(),
                                'resource'      => 'rentalobjects',
                                'contentType'   => 'application/json',
                                'id'            => 1
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('delete');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange ett id för borttagning.
    */
   public function testDeleteWithoutId(){
      $request = new Request(array(
                                'requestMethod' => 'DELETE',
                                'requestData'   => array(),
                                'resource'      => 'rentalobjects',
                                'contentType'   => 'application/json',
                                'id'            => ''
                             ));

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   public function testValidateGetters(){
      $request = new Request(array(
                                'requestMethod' => 'DELETE',
                                'requestData'   => array(),
                                'resource'      => 'rentalobjects',
                                'contentType'   => 'application/json',
                                'id'            => 1,
                                'action'        => 'login'
                             ));

      $this->assertEquals('DELETE', $request->getRequestMethod());
      $this->assertEquals('login', $request->getAction());
      $this->assertEquals(1, $request->getId());
      $this->assertEquals('rentalobjects', $request->getResource());
   }
} 