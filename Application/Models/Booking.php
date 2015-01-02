<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 16:05
 */

namespace Application\Models;

use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\Interfaces\IToArray;

class Booking implements IToArray{

   private $rentPeriodId;
   private $fromDate;
   private $toDate;
   private $rentalObjectOwnerName;
   private $rentalObjectName;


   public function __construct(array $data){
      $this->setData($data);
   }

   protected function setData(array $data){
      foreach ($data as $propertyName => $value){
         $this->setPropertyValue($propertyName, $value);
      }

      return $this;
   }

   private function setPropertyValue($propertyName, $value){
      $this->checkPropertyExists($propertyName);
      $this->$propertyName = $value;
   }

   private function checkPropertyExists($propertyName){
      if (!property_exists($this, $propertyName)){
         throw new ApplicationException('Ogiltigt egenskapsnamn.');
      }

      return true;
   }

   /**
    * @return array
    */
   public function toArray(){
      return get_object_vars($this);
   }
}
