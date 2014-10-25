<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/10/14
 * Time: 13:16
 */

namespace Tests\ModelTests;


use Application\Models\User;

class UserTest extends \PHPUnit_Framework_TestCase{

   public function testGetPassword(){
      $user = new User(array('password' => 'Marknadskaramell007'));
      $this->assertEquals('Marknadskaramell007', $user->getPassword());
   }
} 