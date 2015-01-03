<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 10:10
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\AddressValidation;

class AddressValidationTest extends \PHPUnit_Framework_TestCase{
   public function testValidate(){

      $addressValidation = new AddressValidation(array('genericName' => '', 'propertyName' => 'address'));

      $this->assertTrue($addressValidation->validate('Sjövägen 19'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig adress.
    */
   public function testInvalidAddress(){
      $addressValidation = new AddressValidation(array('genericName' => '', 'propertyName' => 'address'));

      $addressValidation->validate('Sjöväg€n');
   }
} 