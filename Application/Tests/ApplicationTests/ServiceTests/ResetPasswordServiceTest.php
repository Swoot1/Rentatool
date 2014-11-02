<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 20/10/14
 * Time: 14:12
 */

namespace Tests\ServiceTests;


use Application\Services\ResetPasswordService;

class ResetPasswordServiceTest extends \PHPUnit_Framework_TestCase{

   private $resetPasswordFactoryMock;
   private $userServiceMock;

   public function setUp(){
      $this->resetPasswordFactoryMock = $this->getMockBuilder('Application\Factories\ResetPasswordFactory')
                                             ->disableOriginalConstructor()
                                             ->getMock();

      $this->userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                                    ->disableOriginalConstructor()
                                    ->getMock();
   }

   public function testDelete(){

      $resetPasswordMapperMock = $this->getMockBuilder('Application\Mappers\ResetPasswordMapper')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $resetPasswordMapperMock->expects($this->once())
                              ->method('delete');

      $resetPasswordService = new ResetPasswordService($resetPasswordMapperMock, $this->resetPasswordFactoryMock, $this->userServiceMock);

      $resetPasswordService->delete(1);
   }

   public function testReadActiveResetPassword(){
      $resetPasswordMapperMock = $this->getMockBuilder('Application\Mappers\ResetPasswordMapper')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $resetPasswordMapperMock->expects($this->once())
                              ->method('readActiveResetPassword')
                              ->will($this->returnValue(array()));

      $resetPasswordService = new ResetPasswordService($resetPasswordMapperMock, $this->resetPasswordFactoryMock, $this->userServiceMock);

      $resetPassword = $resetPasswordService->readActiveResetPassword('5442ad085370f');

      $this->assertInstanceOf('Application\Models\ResetPassword', $resetPassword);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage återställningskod måste vara alfanumeriskt.
    */
   public function testReadActiveResetPasswordInvalidReset(){
      $resetPasswordMapperMock = $this->getMockBuilder('Application\Mappers\ResetPasswordMapper')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $resetPasswordService = new ResetPasswordService($resetPasswordMapperMock, $this->resetPasswordFactoryMock, $this->userServiceMock);
      $resetPasswordService->readActiveResetPassword('5442ad085370ff'); // Too long
   }

   public function testCreate(){

      $_SERVER['SERVER_NAME'] = '';

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getEmail')
               ->will($this->returnValue('nilsson@1337.se'));

      $this->userServiceMock->expects($this->once())
                            ->method('getUserByEmail')
                            ->will($this->returnValue($userMock));

      $resetPasswordMock = $this->getMockBuilder('Application\Models\ResetPassword')
                                ->disableOriginalConstructor()
                                ->getMock();

      $resetPasswordMock->expects($this->once())
                        ->method('getDBParameters')
                        ->will($this->returnValue(array()));

      $this->resetPasswordFactoryMock->expects($this->once())
                                     ->method('build')
                                     ->will($this->returnValue($resetPasswordMock));

      $resetPasswordMapperMock = $this->getMockBuilder('Application\Mappers\ResetPasswordMapper')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $resetPasswordMapperMock->expects($this->once())
                              ->method('create')
                              ->will($this->returnValue(array()));

      $mailFactoryMock = $this->getMockBuilder('Application\Factories\MailFactory')
                              ->disableOriginalConstructor()
                              ->getMock();


      $mailMock = $this->getMockBuilder('\PHPMailer')
                       ->disableOriginalConstructor()
                       ->getMock();

      $mailMock->expects($this->once())
               ->method('send')
               ->will($this->returnValue(true));

      $mailFactoryMock->expects($this->once())
                      ->method('build')
                      ->will($this->returnValue($mailMock));

      $resetPasswordService = new ResetPasswordService($resetPasswordMapperMock, $this->resetPasswordFactoryMock, $this->userServiceMock);

      $resetPasswordService->create(array('email' => 'nilsson@1337.se'), $mailFactoryMock);

      unset($_SERVER['SERVER_NAME']);
   }
} 