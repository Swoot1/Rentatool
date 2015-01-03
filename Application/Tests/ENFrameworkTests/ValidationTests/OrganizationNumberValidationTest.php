<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 08:16
 */

namespace Tests\PHPFrameworkTests\ValidationTests;


use Application\PHPFramework\Validation\OrganizationNumberValidation;

class OrganizationNumberValidationTest extends \PHPUnit_Framework_TestCase{
   public function testCompanyOrganizationNumber(){
      $organizationNumberValidation = new OrganizationNumberValidation(array('genericName' => 'organisationsnummer', 'propertyName' => 'organizationNumber'));
      $this->assertTrue($organizationNumberValidation->validate(5564696291));
   }

   public function testSocialSecurityNumberAsOrganizationNumber(){
      $organizationNumberValidation = new OrganizationNumberValidation(array('genericName' => 'organisationsnummer', 'propertyName' => 'organizationNumber'));
      $this->assertTrue($organizationNumberValidation->validate(199003070464));
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt organisationsnummer/personnummer.
    */
   public function testInvalidOrganizationNumber(){
      $organizationNumberValidation = new OrganizationNumberValidation(array('genericName' => 'organisationsnummer', 'propertyName' => 'organizationNumber'));
      $organizationNumberValidation->validate(5564696292);
   }
} 