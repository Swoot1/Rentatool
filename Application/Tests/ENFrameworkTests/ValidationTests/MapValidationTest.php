<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 23/10/14
 * Time: 18:28
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\MapValidation;

class MapValidationTest extends \PHPUnit_Framework_TestCase{
   public function testObjectValidation(){
      $mapValidation = new MapValidation(array('map' => array('apa', 123)));

      $result = $mapValidation->validate('apa');

      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage mittpropertynamn innehåller ett otillåtet värde.
    */
   public function testInvalidObjectValidation(){
      $mapValidation = new MapValidation(array('map' => array('apa', 123), 'genericName' => 'mittpropertynamn'));
      $mapValidation->validate('apa som inte finns.');
   }
} 