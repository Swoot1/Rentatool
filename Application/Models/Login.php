<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/10/14
 * Time: 12:44
 */

namespace Application\Models;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\EmailValidation;
use Application\PHPFramework\Validation\PasswordValidation;

class Login extends GeneralModel{
   protected $email;
   protected $password;

   public function getEmail(){
      return $this->email;
   }

   public function getPassword(){
      return $this->password;
   }

   public function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new EmailValidation(
               array(
                  'propertyName' => 'email',
                  'genericName'  => 'epost-adress'
               )
            ),
            new PasswordValidation(
               array(
                  'propertyName' => 'password',
                  'genericName'  => 'lösenord'
               )
            )
         )
      );
   }
} 