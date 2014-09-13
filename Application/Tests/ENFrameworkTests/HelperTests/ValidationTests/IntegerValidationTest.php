<?php
/**
 * User: Elin
 * Date: 2014-07-04
 * Time: 09:09
 */

namespace Tests\ENFrameworkTests\HelperTests\ValidationTests;

use Application\ENFramework\Helpers\Validation\IntegerValidation;

class IntegerValidationTest extends \PHPUnit_Framework_TestCase{
   /**
    * Test that the most common case with a positive integer works fine.
    */
   public function testValidateNormalCase(){
      $integerValidation = new IntegerValidation(array());
      $result            = $integerValidation->validate(13);
      $this->assertTrue($result);
   }

   /**
    * Test that it's possible to have negative integers if allowed.
    */
   public function testValidateAllowedNegativeInteger(){
      $integerValidation = new IntegerValidation(array('allowNegativeInteger' => true));
      $result            = $integerValidation->validate(-5433);
      $this->assertTrue($result);
   }

   /**
    * Test that an expection is thrown when a string is inserted.
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName måste bestå av siffror.
    */
   public function testValidateWithString(){
      $integerValidation = new IntegerValidation(array('genericName' => 'propertyName'));
      $integerValidation->validate('trettonhundra');
   }

   /**
    * Test that an exception is thrown when a negative number is inserted and it's
    * not allowed.
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName får inte vara negativt.
    */
   public function testUnAllowedNegativeNumber(){
      $integerValidation = new IntegerValidation(array('genericName' => 'propertyName'));
      $result            = $integerValidation->validate(-45566);
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange ett värde för propertyName.
    */
   public function testUnAllowedNullValue(){
      $integerValidation = new IntegerValidation(array('genericName' => 'propertyName'));
      $integerValidation->validate(null);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName måste bestå av siffror.
    */
   public function testValidateWithNumericString(){
      $floatValidation = new IntegerValidation(array('genericName' => 'propertyName'));
      $floatValidation->validate('577443');
   }
} 