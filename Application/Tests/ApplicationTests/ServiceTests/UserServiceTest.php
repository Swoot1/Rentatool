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

   private $userValidationMapperMock;
   private $userMapperMock;

   public function setUp(){
      $this->userValidationMapperMock = $this->getMockBuilder('\Application\Mappers\UserValidationMapper')->
         disableOriginalConstructor()->
         getMock();

      $this->userMapperMock = $this->getMockBuilder('\Application\Mappers\UserMapper')->
         disableOriginalConstructor()->
         getMock();
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Användarnamnet är redan upptaget.
    */
   public function testUniqueUsername(){

      $this->userValidationMapperMock->expects($this->any())
                                     ->method('isUniqueUsername')
                                     ->will($this->returnValue(false));

      $userValidationService = new UserValidationService($this->userValidationMapperMock);

      $userService = new UserService($this->userMapperMock, $userValidationService);
      $userService->create(array('username' => 'Elin',
                                 'email'    => 'elin@elin.se',
                                 'password' => 'elin1234'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage E-mailadressen används redan.
    */
   public function testUniqueEmail(){


      $this->userValidationMapperMock->expects($this->any())
                                     ->method('isUniqueUsername')
                                     ->will($this->returnValue(true));
      $this->userValidationMapperMock->expects($this->any())
                                     ->method('isUniqueEmail')
                                     ->will($this->returnValue(false));

      $userValidationService = new UserValidationService($this->userValidationMapperMock);

      $userService = new UserService($this->userMapperMock, $userValidationService);
      $userService->create(array('username' => 'Elin',
                                 'email'    => 'elin@elin.se',
                                 'password' => 'elin1234'));
   }

   public function testPerfectCase(){

      $this->userMapperMock->expects($this->once())
                     ->method('create')
                     ->will($this->returnValue(array()));

      $this->userValidationMapperMock->expects($this->any())->method('isUniqueUsername')->will($this->returnValue(true));
      $this->userValidationMapperMock->expects($this->any())->method('isUniqueEmail')->will($this->returnValue(true));

      $userValidationService = new UserValidationService($this->userValidationMapperMock);

      $userService = new UserService($this->userMapperMock, $userValidationService);
      $user        = $userService->create(array('username' => 'Elin',
                                                'email'    => 'elin@elin.se',
                                                'password' => 'elin1234'));

      $this->assertInstanceOf('Application\Models\User', $user);
   }
} 
