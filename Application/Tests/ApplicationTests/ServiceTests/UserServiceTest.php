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
      $this->userValidationMapperMock = $this->getMockBuilder('\Application\Mappers\UserValidationMapper')
         ->disableOriginalConstructor()
         ->getMock();

      $this->userMapperMock = $this->getMockBuilder('\Application\Mappers\UserMapper')
         ->disableOriginalConstructor()
         ->getMock();
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

   public function testDelete(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('delete');

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $userService->delete(1);
   }

   public function testIndex(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('index')
                           ->will($this->returnValue(array()));

      $userService    = new UserService($this->userMapperMock, $userValidationServiceMock);
      $userCollection = $userService->index();
      $this->assertInstanceOf('Application\Collections\UserCollection', $userCollection);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte hitta användaren.
    */
   public function testReadNotFound(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('read')
                           ->will($this->returnValue(null));

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $userService->read(1);
   }

   public function testRead(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('read')
                           ->will($this->returnValue(array()));

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $user        = $userService->read(1);
      $this->assertInstanceOf('Application\Models\User', $user);
   }

   public function testUpdate(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $userValidationServiceMock->expects($this->once())
                           ->method('validateUser')
                           ->will($this->returnValue(true));

      $this->userMapperMock->expects($this->once())
                           ->method('update')
                           ->will($this->returnValue(array()));

      $this->userMapperMock->expects($this->once())
                           ->method('read')
                           ->will($this->returnValue(array()));

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $user        = $userService->update(1, array('password' => 'Grank0tte332'));
      $this->assertInstanceOf('Application\Models\User', $user);
   }

   public function testGetUserByEmail(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('getUserByEmail')
                           ->will($this->returnValue(array()));

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $user        = $userService->getUserByEmail('knugen@hovet.se');
      $this->assertInstanceOf('Application\Models\User', $user);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte hitta användaren.
    */
   public function testGetUserByEmailNotFound(){
      $userValidationServiceMock = $this->getMockBuilder('Application\Services\UserValidationService')
                                        ->disableOriginalConstructor()
                                        ->getMock();

      $this->userMapperMock->expects($this->once())
                           ->method('getUserByEmail')
                           ->will($this->returnValue(null));

      $userService = new UserService($this->userMapperMock, $userValidationServiceMock);
      $userService->getUserByEmail('knugen@hovet.se');
   }
} 
