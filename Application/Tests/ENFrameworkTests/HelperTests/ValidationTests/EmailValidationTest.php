<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 25/07/14
 * Time: 09:56
 */

namespace Tests\ENFrameworkTests\HelperTests\ValidationTests;


use Application\ENFramework\Helpers\Validation\EmailValidation;

class EmailValidationTest extends \PHPUnit_Framework_TestCase{

   public function testValidateNormalCase(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $result          = $emailValidation->validate('someemail@cooldomain.sexy');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testValidateMissingAtCharacter(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('svänskmejlsvensson.se');
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testValidateMissingDomain(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('rocky@star.');
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testValidateRepeatedEmail(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('missuniverse@g.comissuniverse@g.co');
   }

   public function testDashIsAllowed(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $result          = $emailValidation->validate('some-email@cool-domain.sexy');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testDashIsNotAllowedAsStart(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('-someemail@cooldomain.sexy');
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testDashIsNotAllowedAsEnd(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('someemail-@cooldomain.sexy');
   }

   public function testValidateShortEmail(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $result          = $emailValidation->validate('e@cooldomain.sexy');
      $this->assertTrue($result);
   }

   public function testValidateNumberEmail(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $result          = $emailValidation->validate('99@hej.visitsmaland');
      $this->assertTrue($result);
   }

   public function testValidateAllowedSiteName(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $result          = $emailValidation->validate('elin@999-hundred-99hours.visitsmaland');
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Värdet angivet för propertyName är en ogiltig email-adress.
    */
   public function testValidateMissingName(){
      $emailValidation = new EmailValidation(array('genericName' => 'propertyName'));
      $emailValidation->validate('@stackoverflow.com');
   }
} 