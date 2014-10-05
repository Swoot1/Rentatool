<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 14:31
 */

namespace Tests\FactoryTests;


use Application\Factories\ResetPasswordFactory;
use Application\Models\User;

class ResetPasswordFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testBuild(){
      $user                 = new User(array('id' => 1));
      $resetPasswordFactory = new ResetPasswordFactory();
      $resetPassword        = $resetPasswordFactory->build($user);

      $this->assertInstanceOf('Application\Models\ResetPassword', $resetPassword);

      $resetPasswordData = $resetPassword->getDBParameters();
      $this->assertEquals(1, $resetPasswordData['userId']);

   }
} 