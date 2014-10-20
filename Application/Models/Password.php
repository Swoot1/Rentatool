<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:20
 */

namespace Application\Models;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Validation\PasswordValidation;
use Application\PHPFramework\Models\GeneralModel;

class Password extends GeneralModel{
   protected $password;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
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