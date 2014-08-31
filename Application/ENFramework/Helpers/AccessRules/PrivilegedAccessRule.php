<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-31
 * Time: 21:30
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers\AccessRules;


use Rentatool\Application\Models\User;

class PrivilegedAccessRule implements IAccessRule {

   public function isAccessAllowed(User $user) {
      return true;
   }

}
