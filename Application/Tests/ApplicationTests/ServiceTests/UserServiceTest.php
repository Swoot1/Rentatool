<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 22:05
 */

namespace Tests\ServiceTests;


use Application\Services\UserService;
use Application\Services\UserValidationService;

class UserServiceTest extends \PHPUnit_Framework_TestCase{
   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Användarnamnet är redan upptaget.
    */
   public function testUniqueUsername(){

      $userValidationMapperMock = $this->getMockBuilder('\Application\Mappers\UserValidationMapper')->
         disableOriginalConstructor()->
         getMock();

      $userMapperMock = $this->getMockBuilder('\Application\Mappers\UserMapper')->
         disableOriginalConstructor()->
         getMock();

      $userValidationMapperMock->expects($this->any())->method('isUniqueUsername')->will($this->returnValue(false));

      $userValidationService = new UserValidationService($userValidationMapperMock);

      $userService = new UserService($userMapperMock, $userValidationService);
      $userService->create(array('username' => 'Elin',
                                 'email'    => 'elin@elin.se',
                                 'password' => 'elin1234'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage E-mailadressen används redan.
    */
   public function testUniqueEmail(){
      $userValidationMapperMock = $this->getMockBuilder('\Application\Mappers\UserValidationMapper')->
         disableOriginalConstructor()->
         getMock();

      $userMapperMock = $this->getMockBuilder('\Application\Mappers\UserMapper')->
         disableOriginalConstructor()->
         getMock();

      $userValidationMapperMock->expects($this->any())->method('isUniqueUsername')->will($this->returnValue(true));
      $userValidationMapperMock->expects($this->any())->method('isUniqueEmail')->will($this->returnValue(false));

      $userValidationService = new UserValidationService($userValidationMapperMock);

      $userService = new UserService($userMapperMock, $userValidationService);
      $userService->create(array('username' => 'Elin',
                                 'email'    => 'elin@elin.se',
                                 'password' => 'elin1234'));
   }
} 
