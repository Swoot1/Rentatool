<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 21:40
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Collections;

use Application\ENFramework\Collections\GeneralCollection;


class UserGroupCollection extends GeneralCollection{

   protected $model = 'Application\Models\UserGroup';

   public function hasAdministrativeAccess(){
      $hasAdministrativeAccess = false;

      foreach ($this->data as $group){
         if ($group->hasAdministrativeAccess()){
            $hasAdministrativeAccess = true;
         }
      }

      return $hasAdministrativeAccess;
   }
}