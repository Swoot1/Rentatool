<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/11/14
 * Time: 10:04
 */

namespace Application\Models;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\BooleanValidation;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;

class ConfirmEmail extends GeneralModel{

   protected $confirmed = true;

   public function setupValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new BooleanValidation(
               array(
                  'genericName'  => 'bekräftad e-postadress',
                  'propertyName' => 'confirmed',
               )
            )
         )
      );
   }
} 