<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 10:03
 */

namespace Tests\PHPFrameworkTests\HelperTests\ValidationTests;

use Application\PHPFramework\Validation\AlphaNumericValidation;

class AlphaNumericValidationTest extends \PHPUnit_Framework_TestCase{


   public function testNormalCaseAlphaNumeric(){

      $alphaNumericValidation = new AlphaNumericValidation(
         array(
            'genericName'  => 'Användarnamn',
            'propertyName' => 'userName',
            'maxLength'    => 20
         )
      );

      $result = $alphaNumericValidation->validate('Svängigt1');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Användarnamn måste vara alfanumeriskt.
    */
   public function testUnAllowedAlphaNumeric(){

      $alphaNumericValidation = new AlphaNumericValidation(
         array(
            'genericName'  => 'Användarnamn',
            'propertyName' => 'userName'
         )
      );

      $alphaNumericValidation->validate('ABC_123');
   }
} 