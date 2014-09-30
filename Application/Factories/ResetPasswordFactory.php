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
      $data['resetCode'] = $this->generateResetCode();
      return new ResetPassword($data);
   }

   // http://stackoverflow.com/questions/3290283/what-is-a-good-way-to-produce-a-random-site-salt-to-be-used-in-creating-passwo/3291689#3291689
   private function generateResetCode(){
      return 123; // TODO
   }
} 