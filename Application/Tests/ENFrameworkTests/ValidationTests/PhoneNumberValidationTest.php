<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 09:38
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\PhoneNumberValidation;

class PhoneNumberValidationTest extends \PHPUnit_Framework_TestCase{
   public function testValidate(){
      $phoneNumberValidation = new PhoneNumberValidation(
         array('genericName' => 'telefonnummer', 'propertyName' => 'phoneNumber')
      );

      $this->assertTrue($phoneNumberValidation->validate('0534-540091'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt telefonnummer.
    */
   public function testInvalidPhoneNumber(){
      $phoneNumberValidation = new PhoneNumberValidation(
         array('genericName' => 'telefonnummer', 'propertyName' => 'phoneNumber')
      );

      $phoneNumberValidation->validate('+4670 55 34 45');
   }
} 