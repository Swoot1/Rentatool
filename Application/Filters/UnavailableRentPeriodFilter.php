<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:49
 */

namespace Application\Filters;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Models\GeneralModel;

class UnavailableRentPeriodFilter extends GeneralModel{
   protected $rentalObjectId = null;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'genericName'  => 'filtrets id för uthyrningsobjekt',
                  'propertyName' => 'rentalObjectId'
               )
            )
         )
      );
   }

   /**
    * @param array $data
    * @return $this
    */
   protected function setData(array $data){
      foreach ($data as $propertyName => $value){
         if (property_exists($this, $propertyName)){
            $this->_validation->validate($propertyName, $value);
            $this->$propertyName = $value;
         }
      }

      return $this;
   }

   /**
    * @param $query
    * @return string
    */
   public function getFilterQuery($query){

      if ($this->rentalObjectId != null){
         $query .= ' WHERE rental_object_id = :rentalObjectId';
      }

      return $query;
   }

   /**
    * Returns the filters with a value.
    * @return array
    */
   public function getFilterParams(){
      $DBParams = $this->getDBParameters();

      return array_filter($DBParams, function ($value){
         return $value != null;
      });
   }
} 