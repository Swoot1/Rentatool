<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 17:44
 */

namespace Tests\PHPFrameworkTests\HelperTests\ValidationTests;


use Application\PHPFramework\Validation\TextValidation;

class TextValidationTest extends \PHPUnit_Framework_TestCase{
   public function testObjectValidation() {

      $textValidation = new TextValidation(
         array(
            'genericName'  => 'beskrivning',
            'propertyName' => 'description',
            'maxLength'    => 500
         )
      );

      $result = $textValidation->validate('aÖ50!#$% \'&()*+,./:;<=>?@^_{|}~[]\-');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt värde för beskrivning.
    */
   public function testUnAllowedTextCharacters() {

      $textValidation = new TextValidation(
         array(
            'genericName'  => 'beskrivning',
            'propertyName' => 'description',
         )
      );

      $textValidation->validate('asd½§§§123');
   }
} 