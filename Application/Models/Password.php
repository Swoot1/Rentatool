<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:20
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Validation\AlphaNumericValidation;
use Application\ENFramework\Validation\IntegerValidation;
use Application\ENFramework\Validation\PasswordValidation;
use Application\ENFramework\Models\GeneralModel;

class Password extends GeneralModel{
   protected $password;
   protected $resetCode;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'propertyName' => 'userId',
                  'genericName'  => 'användarid'
               )
            ),
            new PasswordValidation(
               array(
                  'propertyName' => 'password',
                  'genericName'  => 'lösenord'
               )
            ),
            new AlphaNumericValidation(
               array(
                  'propertyName' => 'resetCode',
                  'genericName'  => 'återställningskod',
                  'maxLength'    => 13
               )
            )
         )
      );
   }

   public function getResetCode(){
      return $this->resetCode;
   }

   public function getUserId(){
      return $this->userId;
   }
} 