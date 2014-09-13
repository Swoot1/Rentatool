<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-31
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers\AccessRules;


use Application\Models\User;

interface IAccessRule {

   public function isAccessAllowed(User $user);

}
