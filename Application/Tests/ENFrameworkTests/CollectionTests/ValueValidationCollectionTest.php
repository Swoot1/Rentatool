<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 13:45
 */

namespace Rentatool\Tests\ENFrameworkTests\CollectionTests;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\BooleanValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;

class ValueValidationCollectionTest extends \PHPUnit_Framework_TestCase {

   public function testNormalCase() {
      $validation = array(
         new BooleanValidation(array('genericName' => 'flagga', 'propertyName' => 'flag')),
      );

      $valueValidationCollection = new ValueValidationCollection($validation);

      $result = $valueValidationCollection->validate('flag', true);
      $this->assertTrue($result);
   }

   /**
    * Try to validate a propertyName that doesn't have a validation. An exception should be thrown.
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Det finns ingen validering för angivet propertynamn flagg.
    */
   public function testWrongPropertyName() {
      $validation = array(
         new BooleanValidation(array('genericName' => 'flagga', 'propertyName' => 'flag')),
      );

      $valueValidationCollection = new ValueValidationCollection($validation);

      $valueValidationCollection->validate('flagg', true);
   }

   /**
    * An Exception should be thrown when the value is invalid.
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Antal måste bestå av siffror.
    */
   public function testInvalidValue() {
      $validation = array(
         new IntegerValidation(array('genericName' => 'Antal', 'propertyName' => 'numberOf')),
      );

      $valueValidationCollection = new ValueValidationCollection($validation);

      $valueValidationCollection->validate('numberOf', 'tjugotvå');
   }
} 