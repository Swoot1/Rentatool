<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:40
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\EmailValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\StringValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class User extends GeneralModel {

   protected $id;
   protected $username;
   protected $email;
   protected $password;

   protected function setUpValidation() {
      $this->setValidation(new ValueValidationCollection(array(
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'Användarid',
                                                                                     'propertyName' => 'id'
                                                                                  )),
                                                            new StringValidation(array(
                                                                                    'genericName'  => 'Användarnamn',
                                                                                    'propertyName' => 'username'
                                                                                 )),
                                                            new EmailValidation(array(
                                                                                   'genericName'  => 'Epost-adress',
                                                                                   'propertyName' => 'email'
                                                                                )),
                                                            new StringValidation(array(
                                                                                    'genericName'  => 'Lösenord',
                                                                                    'propertyName' => 'password'
                                                                                 ))
                                                         )));
   }

   /**
    * @param $password
    * @return bool
    */
   public function isValidPassword($password) {
      return password_verify($password, $this->password);
   }

   public function getId() {
      return $this->id;
   }
} 