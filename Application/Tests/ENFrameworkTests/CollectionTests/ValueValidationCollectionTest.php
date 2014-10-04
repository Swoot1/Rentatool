<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 13:45
 */

namespace Tests\PHPFrameworkTests\CollectionTests;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\BooleanValidation;
use Application\PHPFramework\Validation\IntegerValidation;

class ValueValidationCollectionTest extends \PHPUnit_Framework_TestCase{

   public function testNormalCase(){
      $validation = array(
         new BooleanValidation(array('genericName' => 'flagga', 'propertyName' => 'flag')),
      );

      $valueValidationCollection = new ValueValidationCollection($validation);

      $result = $valueValidationCollection->validate('flag', true);
      $this->assertTrue($result);
   }

   /**
    * An Exception should be thrown when the value is invalid.
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Antal måste bestå av siffror.
    */
   public function testInvalidValue(){
      $validation = array(
         new IntegerValidation(array('genericName' => 'Antal', 'propertyName' => 'numberOf')),
      );

      $valueValidationCollection = new ValueValidationCollection($validation);

      $valueValidationCollection->validate('numberOf', 'tjugotvå');
   }
} 