<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 22:05
 */

namespace Tests\ServiceTests;


use Rentatool\Application\Services\UserService;

class UserServiceTest extends \PHPUnit_Framework_TestCase{
   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Användarnamnet är redan upptaget.
    */
   public function testUniqueUsername(){
      $userMapperMock = $this->getMockBuilder('\Rentatool\Application\Mappers\UserMapper')->
         disableOriginalConstructor()->
         getMock();
      $userMapperMock->expects($this->any())->method('isUniqueUsername')->will($this->returnValue(false));
      $userService = new UserService($userMapperMock);
      $userService->create(array('username' => 'Elin',
                                 'email'    => 'elin@elin.se',
                                 'password' => 'elin'));
   }
} 
