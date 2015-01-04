<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 09:38
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\ZipCodeValidation;

class ZipCodeValidationTest extends \PHPUnit_Framework_TestCase{
   public function testValidate(){
      $zipCodeValidation = new ZipCodeValidation(
         array('genericName' => 'Postnummer', 'propertyName' => 'zipCode')
      );

      $this->assertTrue($zipCodeValidation->validate('352 56'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt postnummer.
    */
   public function testInvalidZipCode(){
      $zipCodeValidation = new ZipCodeValidation(
         array('genericName' => 'postnummer', 'propertyName' => 'zipCode')
      );

      $zipCodeValidation->validate(356);
   }
} 