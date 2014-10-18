<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 20:20
 */

namespace Tests\ServiceTests;


use Application\Services\PasswordService;

class PasswordServiceTest extends \PHPUnit_Framework_TestCase{
   public function testCreate(){
      $passwordMapperMock = $this->getMockBuilder('Application\Mappers\PasswordMapper')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $resetPasswordServiceMock = $this->getMockBuilder('Application\Services\ResetPasswordService')
                                       ->disableOriginalConstructor()
                                       ->getMock();

      $resetPasswordMock = $this->getMockBuilder('Application\Models\ResetPassword')
                                ->disableOriginalConstructor()
                                ->getMock();


      $resetPasswordMock->expects($this->once())
                        ->method('getUserId')
                        ->will($this->returnValue(1));

      $resetPasswordServiceMock->expects($this->once())
                               ->method('readActiveResetPassword')
                               ->will($this->returnValue($resetPasswordMock));


      $resetPasswordServiceMock->expects($this->once())
                               ->method('delete');

      $passwordMapperMock->expects($this->once())
                         ->method('create');

      $passwordService = new PasswordService($passwordMapperMock, $resetPasswordServiceMock);

      $passwordService->create('5442ad085370f', array());
   }
} 