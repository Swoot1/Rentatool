<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:40
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\Collections\UserGroupCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\AlphaNumericValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\EmailValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\PasswordValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class User extends GeneralModel{

   protected $id;
   protected $username;
   protected $email;
   protected $password;
   protected $groups;

   public function __construct(array $data) {
      parent::__construct($data);
      $this->setNoDBProperties(array(
                                    'groups'
                               ));
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

   /**
    * @param UserGroupCollection $userGroups
    */
   public function setGroups(UserGroupCollection $userGroups) {
      $this->groups = $userGroups;
   }
} 