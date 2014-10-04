<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/09/14
 * Time: 11:37
 */

namespace Application\Models;


use Application\ENFramework\Validation\Collections\ValueValidationCollection;
use Application\ENFramework\Validation\IntegerValidation;
use Application\ENFramework\Models\GeneralModel;

class RentalObjectFileDependency extends GeneralModel{
   protected $id;
   protected $rentalObjectId;
   protected $fileId;

   public function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'genericName'  => 'Bildberoendets id',
                  'propertyName' => 'id'
               )
            ),
            new IntegerValidation(
               array(
                  'genericName'  => 'uthyrningsobjektets id',
                  'propertyName' => 'rentalObjectId'
               )
            ),
            new IntegerValidation(
               array(
                  'genericName'  => 'filens id',
                  'propertyName' => 'fileId'
               )
            )
         )
      );
   }
} 