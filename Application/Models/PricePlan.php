<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 16:11
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\FloatValidation;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Models\GeneralModel;

class PricePlan extends GeneralModel{
   protected $id;
   protected $rentalObjectId;
   protected $timeUnitId;
   protected $price;

   public function setRentalObjectId(RentalObject $rentalObject){
      $this->rentalObjectId = $rentalObject->getId();
      return $this;
   }

   public function getRentalObjectId(){
      return $this->rentalObjectId;
   }

   public function getTimeUnitId(){
      return $this->timeUnitId;
   }

   public function getPrice(){
      return $this->price;
   }

   public function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'propertyName' => 'id',
                  'genericName' => 'id'
               )
            ),
            new IntegerValidation(
               array(
                  'propertyName' => 'rentalObjectId',
                  'genericName' => 'uthyrningsobjektets id'
               )
            ),
            new IntegerValidation(
               array(
                  'propertyName' => 'timeUnitId',
                  'genericName' => 'tidsenhetens id'
               )
            ),
            new FloatValidation(
               array(
                  'propertyName' => 'price',
                  'genericName' => 'pris'
               )
            )
         )
      );
   }
} 