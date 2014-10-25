<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/10/14
 * Time: 13:09
 */

namespace Tests\ModelTests;


use Application\Models\Login;

class LoginTest extends \PHPUnit_Framework_TestCase{
   public function testGetEmail(){
      $login = new Login(array('email' => 'olle@hamsterpaj.net', 'password' => '123KLD'));

      $this->assertEquals('olle@hamsterpaj.net', $login->getEmail());
   }

   public function testGetPassword(){
      $login = new Login(array('email' => 'olle@hamsterpaj.net', 'password' => '123KLD'));

      $this->assertEquals('123KLD', $login->getPassword());
   }
} 