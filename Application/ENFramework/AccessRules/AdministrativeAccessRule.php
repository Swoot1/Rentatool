<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-31
 * Time: 21:30
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\AccessRules;


use Application\Models\User;

class AdministrativeAccessRule implements IAccessRule{

   /**
    * @param User $user
    * @return bool
    */
   public function isAccessAllowed(User $user){
      return $user->hasAdministrativeAccess();
   }
}
