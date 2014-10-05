<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 15:40
 */

namespace Application\Filters;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\DateTimeValidation;
use Application\PHPFramework\Validation\TextValidation;
use Application\PHPFramework\Models\GeneralModel;

class RentalObjectFilter extends GeneralModel{
   protected $query = null;
   protected $fromDate = null;
   protected $toDate = null;

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

      $filters = array_merge($this->getDateStringFilters(), $this->getQueryFilters());

      if (count($filters) > 0){
         $filterString = implode(' AND ', $filters);
         $query .= sprintf('%s%s', ' WHERE ', $filterString);
      }

      return $query;
   }

   /**
    * @return array
    */
   private function getQueryFilters(){
      $result = array();

      if ($this->query){
         $result[] = 'name = :query';
      }

      return $result;
   }

   /**
    * @return $this
    */
   protected function setupValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new TextValidation(
               array(
                  'genericName'  => 'Söksträng',
                  'propertyName' => 'query',
                  'minLength'    => 0
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'Från datum',
                  'propertyName' => 'fromDate'
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'Till datum',
                  'propertyName' => 'toDate'
               )
            )
         )
      );

      return $this;
   }

   private function getDateStringFilters(){

      $filters = $this->getFromDateFilters();
      $filters = array_merge($filters, $this->getToDateFilters());
      $filters = array_merge($filters, $this->getFromAndToDateFilters());
      $result  = array();

      if (count($filters) > 0){
         $result[] = sprintf('NOT EXISTS(
                  SELECT id
                   FROM
                     rent_periods
                  WHERE
                        rental_objects.id = rent_periods.rental_object_id
                     AND
                     (

                        %s

                     )
                 )', implode(' OR ', $filters));
      }

      return $result;

   }

   /**
    * @return array
    */
   private function getFromDateFilters(){
      $result = array();

      if ($this->fromDate){
         $result[] = '(
                           :fromDate >= rent_periods.from_date
                        AND
                           :fromDate <= rent_periods.to_date
                     )';
      }

      return $result;
   }

   /**
    * @return array
    */
   private function getToDateFilters(){
      $result = array();

      if ($this->toDate){
         $result[] = '(
                           :toDate <= rent_periods.to_date
                        AND
                           :toDate >= rent_periods.from_date
                     )';
      }

      return $result;
   }

   /**
    * @return array
    */
   private function getFromAndToDateFilters(){
      $result = array();

      if ($this->fromDate && $this->toDate){
         $result[] = '(
                           :fromDate <= rent_periods.to_date
                        AND
                           :toDate >= rent_periods.from_date
                     )';
      }

      return $result;
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