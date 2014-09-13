<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-31
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers\AccessRules;


use Application\Models\User;

class AuthorizedAccessRule implements IAccessRule {

   public function isAccessAllowed(User $user) {
      return true;
   }

}
