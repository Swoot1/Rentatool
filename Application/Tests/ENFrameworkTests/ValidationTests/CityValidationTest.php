<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 10:10
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\CityValidation;

class CityValidationTest extends \PHPUnit_Framework_TestCase{
   public function testValidate(){

      $addressValidation = new CityValidation(array('genericName' => '', 'propertyName' => 'address'));

      $this->assertTrue($addressValidation->validate('Boden'));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig stad.
    */
   public function testInvalidAddress(){
      $addressValidation = new CityValidation(array('genericName' => '', 'propertyName' => 'address'));

      $addressValidation->validate('Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå Boden Karlstad Umeå ');
   }
} 