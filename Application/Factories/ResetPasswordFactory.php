<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:35
 */

namespace Application\Factories;


use Application\Models\ResetPassword;
use Application\Models\User;

class ResetPasswordFactory {

   public function build(User $user){
      $data = array();
      $data['userId'] = $user->getId();
      $data['resetCode'] = uniqid();
      return new ResetPassword($data);
   }
}