<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 15:40
 */

namespace Rentatool\Application\Filters;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\TextValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class RentalObjectFilter extends GeneralModel{
   protected $query;

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

      if ($this->query){
         $query .= ' WHERE name = :query';
      }

      return $query;
   }

   /**
    * @return $this
    */
   public function setupValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new TextValidation(array(
                                  'genericName'  => 'Söksträng',
                                  'propertyName' => 'query',
                                  'minLength' => 0
                               )
            )
         )
      );

      return $this;
   }
} 