<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/10/14
 * Time: 13:41
 */

namespace Tests\PHPFrameworkTests\ConfigurationTests;


use Application\PHPFramework\Configurations\MailConfiguration;

class MailConfigurationTest extends \PHPUnit_Framework_TestCase{
   public function testGet(){
      $mailConfiguration = new MailConfiguration();

      $this->assertEquals('kundtjanst@hyrdet.se', $mailConfiguration->get('from'));
   }


   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt egenskapsnamn.
    */
   public function testGetInvalidProperty(){
      $mailConfiguration = new MailConfiguration();
      $mailConfiguration->get('nameThatDoesntExist');
   }
} 