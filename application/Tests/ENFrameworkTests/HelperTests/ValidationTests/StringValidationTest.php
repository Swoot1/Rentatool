<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 22:15
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests\ValidationTests;

use Rentatool\Application\ENFramework\Helpers\Validation\StringValidation;

class StringValidationTest extends \PHPUnit_Framework_TestCase{

   /**
    * Test that ö is ok and doesn't count as two characters.
    */
   public function testValidateMaxLengthLikeASwede(){
      $stringValidation = new StringValidation(array('genericName' => 'pröppertyName', 'maxLength' => 10));
      $result           = $stringValidation->validate('Ö ströngör');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName får vara högst 10 tecken långt.
    */
   public function testValidateTooLongString(){
      $stringValidation = new StringValidation(array('genericName' => 'propertyName', 'maxLength' => 10));
      $stringValidation->validate('Lorem ipsum');
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName måste vara minst 3 tecken långt.
    */
   public function testValidateTooShortString(){
      $stringValidation = new StringValidation(array('genericName' => 'propertyName', 'minLength' => 3));
      $stringValidation->validate('ab');
   }
} 