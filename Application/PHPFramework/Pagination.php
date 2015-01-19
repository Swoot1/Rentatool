<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 19/01/15
 * Time: 09:19
 */

namespace Application\PHPFramework;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\IntegerValidation;

class Pagination extends GeneralModel implements IPagination{
   protected $page;
   protected $entryLimit = 10;
   protected $rowCount = null;
   protected $parameters = array();

   public function __construct(array $data){
      foreach ($data as $key => $value){
         $this->$key = $value;
      }
   }

   /**
    * @param array $data
    * @return $this
    */
   protected function setData(array $data){
      foreach ($data as $propertyName => $value){
         if (array_key_exists($propertyName, $this->_setters)){
            $this->setPropertyValueWithSetter($propertyName, $value);
         } else if (property_exists($this, $propertyName)){
            $this->_validation->validate($propertyName, $value);
            $this->$propertyName = $value;
         }
      }

      return $this;
   }

   public function getPaginatedQuery($query){

      if (!$this->page){
         return $query;
      }

      return 'SELECT * FROM (' . $query . ') AS resultTable ORDER BY id LIMIT ' . $this->getEntryLimitSQL();
   }

   private function getEntryLimitSQL(){
      $entryLimitSQL       = '';
      $zeroBasedPageNumber = $this->page - 1;

      if ($zeroBasedPageNumber > 0){
         $entryLimitSQL .= ':startLimit,';
         $this->parameters['startLimit'] = (int)$zeroBasedPageNumber * $this->entryLimit;
      }

      $entryLimitSQL .= ':endLimit';
      $this->parameters['endLimit'] = (int)$this->entryLimit;

      return $entryLimitSQL;
   }

   public function getRowCountQuery($query){
      return 'SELECT COUNT(*) AS "rowCount" FROM (' . $query . ') AS resultTable';
   }

   public function setRowCount($rowCount){
      $this->rowCount = $rowCount;

      return $this;
   }

   public function getRowCount(){
      return $this->rowCount;
   }

   public function getPaginationParameters(){
      return $this->parameters;
   }

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(array(
                                     'genericName'  => 'sidnummer',
                                     'propertyName' => 'page'
                                  )),
            new IntegerValidation(array(
                                     'genericName'  => 'sidintervall',
                                     'propertyName' => 'entryLimit'
                                  )),
            new IntegerValidation(array(
                                     'genericName'  => 'antal rader',
                                     'propertyName' => 'rowCount'
                                  ))
         )
      );
   }
}