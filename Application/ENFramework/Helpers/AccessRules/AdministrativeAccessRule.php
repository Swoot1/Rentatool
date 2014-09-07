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
use Rentatool\Application\Models\UserGroup;

class AdministrativeAccessRule implements IAccessRule {

   /**
    * @param User $user
    * @return bool
    */
   public function isAccessAllowed(User $user) {
      foreach($user->getGroups() as $group) {
         $group = new UserGroup($group);

         if($group->hasAdministrativeAccess()) {
            return true;
         }
      }

      return false;
   }

}
