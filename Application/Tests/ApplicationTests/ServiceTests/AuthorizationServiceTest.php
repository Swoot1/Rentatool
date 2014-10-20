<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 21:38
 */

namespace Tests\ServiceTests;


use Application\Services\AuthorizationService;

class AuthorizationServiceTest extends \PHPUnit_Framework_TestCase{

   private $sessionManagerMock;
   private $userServiceMock;
   private $userMock;

   public function setUp(){
      $this->sessionManagerMock = $this->getMockBuilder('Application\PHPFramework\SessionManager')
                                       ->disableOriginalConstructor()
                                       ->getMock();

      $this->sessionManagerMock->expects($this->any())
                               ->method('setUserData');

      $this->userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $this->userMock = $this->getMockBuilder('Application\Models\User')
                             ->disableOriginalConstructor()
                             ->getMock();

      $this->userMock->expects($this->any())
                     ->method('toArray')
                     ->will($this->returnValue(array()));
   }

   public function testLogin(){

      $this->userMock->expects($this->any())
                     ->method('isValidPassword')
                     ->will($this->returnValue(true));


      $this->userServiceMock->expects($this->any())
                            ->method('getUserByEmail')
                            ->will($this->returnValue($this->userMock));

      $authorizationService = new AuthorizationService($this->userServiceMock, $this->sessionManagerMock);

      $authorization     = $authorizationService->login(array('email' => 'elin@thecoolest.com', 'password' => 'Rato555'));
      $authorizationData = $authorization->toArray();

      $this->assertTrue($authorizationData['isLoggedIn']);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Fel e-postadress eller användarnamn.
    *
    */
   public function testNonExistingUser(){
      $this->userMock->expects($this->any())
                     ->method('isValidPassword')
                     ->will($this->returnValue(true));


      $this->userServiceMock->expects($this->any())
                            ->method('getUserByEmail')
                            ->will($this->returnValue(null));

      $authorizationService = new AuthorizationService($this->userServiceMock, $this->sessionManagerMock);

      $authorizationService->login(array('email' => 'elin@thecoolest.com', 'password' => 'Rato555'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Fel e-postadress eller användarnamn.
    *
    */
   public function testInvalidPassword(){
      $this->userMock->expects($this->any())
                     ->method('isValidPassword')
                     ->will($this->returnValue(false));


      $this->userServiceMock->expects($this->any())
                            ->method('getUserByEmail')
                            ->will($this->returnValue($this->userMock));

      $authorizationService = new AuthorizationService($this->userServiceMock, $this->sessionManagerMock);

      $authorizationService->login(array('email' => 'elin@thecoolest.com', 'password' => 'Rato555'));
   }

   public function testLogout(){
      $authorizationService = new AuthorizationService($this->userServiceMock, $this->sessionManagerMock);

      $this->sessionManagerMock->expects($this->once())
                               ->method('endSession');
      $authorizationService->logout();
   }
} 