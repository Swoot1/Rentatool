<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 09:06
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\LuhnValidation;

class LuhnValidationTest extends \PHPUnit_Framework_TestCase{
   public function testValidate(){
      $luhnValidation = new LuhnValidation(array('genericName' => 'personnummer', 'propertyName' => 'socialSecurityNumber'));

      $this->assertTrue($luhnValidation->validate(9005076642));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt format på personnummer.
    */
   public function testValidateInvalidNumber(){
      $luhnValidation = new LuhnValidation(array('genericName' => 'personnummer', 'propertyName' => 'socialSecurityNumber'));

      $this->assertTrue($luhnValidation->validate(9005076641));
   }
} 