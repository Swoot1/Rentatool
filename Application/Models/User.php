<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:40
 */

namespace Application\Models;

use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\AlphaNumericValidation;
use Application\ENFramework\Helpers\Validation\BooleanValidation;
use Application\ENFramework\Helpers\Validation\EmailValidation;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Helpers\Validation\PasswordValidation;
use Application\ENFramework\Models\GeneralModel;

class User extends GeneralModel{

   protected $id;
   protected $username;
   protected $email;
   protected $password;
   protected $hasAdministrativeAccess = false;

   public function __construct(array $data){
      parent::__construct($data);
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'Användarid',
                                                                                     'propertyName' => 'id'
                                                                                  )),
                                                            new AlphaNumericValidation(array(
                                                                                          'genericName'  => 'Användarnamn',
                                                                                          'propertyName' => 'username',
                                                                                          'maxLength'    => 50
                                                                                       )),
                                                            new EmailValidation(array(
                                                                                   'genericName'  => 'Epost-adress',
                                                                                   'propertyName' => 'email'
                                                                                )),
                                                            new PasswordValidation(array(
                                                                                      'genericName'  => 'Lösenord',
                                                                                      'propertyName' => 'password'
                                                                                   )),
                                                            new BooleanValidation(array(
                                                                                       'genericName' => 'Administrativ åtkomst',
                                                                                       'propertyName' => 'hasAdministrativeAccess'
                                                                                  ))
                                                         )));
   }

   /**
    * @param $password
    * @return bool
    */
   public function isValidPassword($password){
      return password_verify($password, $this->password);
   }

   /**
    * @return mixed
    */
   public function getId(){
      return $this->id;
   }

   /**
    * @return mixed
    */
   public function getEmail(){
      return $this->email;
   }

   /**
    * @return mixed
    */
   public function getUsername(){
      return $this->username;
   }

   public function hasAdministrativeAccess(){
      return $this->hasAdministrativeAccess;
   }
}