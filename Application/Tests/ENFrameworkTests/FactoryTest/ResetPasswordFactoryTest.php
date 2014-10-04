<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/10/14
 * Time: 10:35
 */

namespace Tests\PHPFrameworkTests\FactoryTest;


use Application\Factories\ResetPasswordFactory;
use Application\Models\ResetPassword;
use Application\Models\User;

class ResetPasswordFactoryTest extends \PHPUnit_Framework_TestCase{
   public function testBuild(){
      $resetPasswordFactory = new ResetPasswordFactory();
      $user = new User(array('id' => 1));
      $resetPassword        = $resetPasswordFactory->build($user);
      $this->assertTrue($resetPassword instanceof ResetPassword);
      $this->assertEquals(1, $resetPassword->getUserId());
   }
} 