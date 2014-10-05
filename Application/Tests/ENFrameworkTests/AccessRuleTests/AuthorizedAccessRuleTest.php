<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-04
 * Time: 16:45
 * To change this template use File | Settings | File Templates.
 */

use Application\Models\User;
use Application\PHPFramework\AccessRules\AuthorizedAccessRule;

class AuthorizedAccessRuleTest extends PHPUnit_Framework_TestCase{

   public function testHasAccess() {
      $accessRule = new AuthorizedAccessRule();
      $access = $accessRule->isAccessAllowed(new User([]));

      $this->assertTrue($access);
   }

}
