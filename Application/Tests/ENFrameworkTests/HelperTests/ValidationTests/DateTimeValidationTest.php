<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:16
 */

namespace Tests\ENFrameworkTests\HelperTests\ValidationTests;


use Application\ENFramework\Validation\DateTimeValidation;

class DateTimeValidationTest extends \PHPUnit_Framework_TestCase{

   /**
    * @expectedException \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt datum angivet för från datum.
    */
   public function testInvalidDate(){
      $dateValidation = new DateTimeValidation(array(
                                                  'genericName'  => 'från datum',
                                                  'propertyName' => 'fromDate'));
      $dateValidation->objectValidation('2014-25-17');
   }

   public function testValidDate(){
      $dateValidation = new DateTimeValidation(array(
                                                  'genericName'  => 'från datum',
                                                  'propertyName' => 'fromDate'));
      $isValid        = $dateValidation->objectValidation('2014-12-17 14:05:22');

      $this->assertTrue($isValid);
   }
} 