<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/10/14
 * Time: 09:37
 */

namespace Tests\PHPFrameworkTests\HelperTests;

use Application\PHPFramework\Request\RequestFactory;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase{
   public function testBuild(){
      $data = array(
         'REQUEST_METHOD' => 'POST',
         'CONTENT_TYPE'   => 'application/json;charset=UTF-8',
         'REQUEST_URI'    => 'rentalobjects',
      );

      $requestBuilder = new RequestFactory($data);
      $request        = $requestBuilder->build();

      $rentalObjectControllerMock = $this->getMockBuilder('Application\Controllers\RentalObjectController')
                                         ->disableOriginalConstructor()
                                         ->getMock();

      $rentalObjectControllerMock->expects($this->once())
                                 ->method('create');

      $request->callControllerMethod($rentalObjectControllerMock);
   }

   /**
    * Test case that makes sure that ids with more than one number works.
    * Earlier only the first number in the id was used.
    */
   public function testMultiNumberId(){

      $data = array(
         'REQUEST_METHOD' => 'POST',
         'CONTENT_TYPE'   => 'application/json;charset=UTF-8',
         'REQUEST_URI'    => 'rentalobjects/14',
      );

      $requestBuilder = new RequestFactory($data);
      $request        = $requestBuilder->build();

      $this->assertEquals('14', $request->getId());
   }
} 