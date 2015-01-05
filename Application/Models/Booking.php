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

class Booking implements IGetRenterId, IToArray{

   private $rentPeriodId;
   private $fromDate;
   private $toDate;
   private $totalPrice;
   private $rentalObjectOwnerName;
   private $cancelled;
   private $rentalObjectName;
   private $renterId;
   private $phoneNumber;
   private $address;
   private $additionalAddressInformation;
   private $zipCode;
   private $city;
   private $email;

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

   public function getRenterId(){
      return $this->renterId;
   }

   /**
    * @return array
    */
   public function toArray(){
      return get_object_vars($this);
   }
}
