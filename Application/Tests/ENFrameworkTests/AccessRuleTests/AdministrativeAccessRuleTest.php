<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-04
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

use Application\Models\User;
use Application\PHPFramework\AccessRules\AdministrativeAccessRule;

class AdministrativeAccessRuleTest extends PHPUnit_Framework_TestCase{

   public function testHasAccess(){
      $accessRule = new AdministrativeAccessRule();
      $access     = $accessRule->isAccessAllowed(new User(['hasAdministrativeAccess' => true]));

      $this->assertTrue($access);
   }

   public function testHasNoAccess() {
      $accessRule = new AdministrativeAccessRule();
      $access = $accessRule->isAccessAllowed(new User(['hasAdministrativeAccess' => false]));

      $this->assertFalse($access);
   }
}
