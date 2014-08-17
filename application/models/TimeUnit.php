<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 15:08
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\TextValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

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