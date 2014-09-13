<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 15:08
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Helpers\Validation\TextValidation;
use Application\ENFramework\Models\GeneralModel;

class TimeUnit extends GeneralModel{

   protected $id;
   protected $name;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'propertyName' => 'id',
                  'genericName' => 'id'
               )
            ),
            new TextValidation(
               array(
                  'propertyName' => 'name',
                  'genericName' => 'tidsenhetens namn',
                  'maxLength' => 30
               )
            )
         )
      );
   }
} 