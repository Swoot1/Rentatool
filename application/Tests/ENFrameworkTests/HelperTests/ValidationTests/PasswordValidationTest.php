<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 09:52
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests\ValidationTests;

use Rentatool\Application\ENFramework\Helpers\Validation\PasswordValidation;

class PasswordValidationTest extends \PHPUnit_Framework_TestCase {

   public function testObjectValidation() {

      $passwordValidation = new PasswordValidation(
         array(
            'genericName'  => 'lösenord',
            'propertyName' => 'password',
         )
      );

      $result = $passwordValidation->validate('aÖ50!#$%\'&()*+,./:;<=>?@^_{|}~[]\-');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt lösenord.
    */
   public function testUnAllowedPasswordCharacters() {

      $passwordValidation = new PasswordValidation(
         array(
            'genericName'  => 'lösenord',
            'propertyName' => 'password',
         )
      );

      $passwordValidation->validate('asd½§§§123');
   }
} 