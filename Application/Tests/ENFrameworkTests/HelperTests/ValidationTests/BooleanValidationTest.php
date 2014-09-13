<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 13:33
 */

namespace Tests\ENFrameworkTests\HelperTests\ValidationTests;


use Application\ENFramework\Helpers\Validation\BooleanValidation;

class BooleanValidationTest extends \PHPUnit_Framework_TestCase {

   public function testValidateNormalCase() {
      $booleanValidation = new BooleanValidation(array('genericName' => 'Flagga', 'propertyName' => 'flag'));
      $result            = $booleanValidation->validate(true);
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Flagga måste vara en boolean.
    */
   public function testValidateIntegerBoolean() {
      $booleanValidation = new BooleanValidation(array('genericName' => 'Flagga', 'propertyName' => 'flag'));
      $booleanValidation->validate(1);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Flagga måste vara en boolean.
    */
   public function testValidateBooleanAsString() {
      $booleanValidation = new BooleanValidation(array('genericName' => 'Flagga', 'propertyName' => 'flag'));
      $booleanValidation->validate('false');
   }

   public function testGetPropertyName() {
      $booleanValidation = new BooleanValidation(array('genericName' => 'Flagga', 'propertyName' => 'flag'));
      $propertyName = $booleanValidation->getPropertyName();
      $this->assertEquals('flag', $propertyName);
   }
} 