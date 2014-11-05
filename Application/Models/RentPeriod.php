<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 18:07
 */

namespace Application\Models;

use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\DateTimeValidation;
use Application\PHPFramework\Validation\FloatValidation;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Models\GeneralModel;

class RentPeriod extends GeneralModel{
   protected $id;
   protected $rentalObjectId;
   protected $renterId;
   protected $fromDate;
   protected $toDate;
   protected $pricePerDay;
   protected $price;
   protected $isConfirmedByOwner = false;
   protected $_setters = array(
      'pricePerDay' => 'setPricePerDay',
      'fromDate'    => 'setFromDate',
      'toDate'      => 'setToDate'
   );
   protected $_noDBProperties = array('price');

   protected function setFromDate($value){
      $this->fromDate = $this->formatDate($value);
      $this->validateFromDateIsBeforeToDate();
      $this->setPrice();

      return $this;
   }

   protected function setToDate($value){
      $this->toDate = $this->formatDate($value);
      $this->validateFromDateIsBeforeToDate();
      $this->setPrice();

      return $this;
   }

   protected function validateFromDateIsBeforeToDate(){
      if ($this->fromDate && $this->toDate && $this->fromDate >= $this->toDate){
         throw new ApplicationException('Från-och-med-datum måste komma före till-och-med-datum.');
      }

      return true;
   }

   private function formatDate($date){

      if (is_string($date) && preg_match('/^\d\d\d\d-\d\d-\d\d$/', $date)){
         $date .= ' 00:00:00';
      }

      return $date;
   }

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'genericName'  => 'id:t',
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
                  'genericName'  => 'id: för personen som hyr',
                  'propertyName' => 'renterId'
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'från datum',
                  'propertyName' => 'fromDate'
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'till datum',
                  'propertyName' => 'toDate'
               )
            ),
            new FloatValidation(
               array(
                  'genericName'      => 'pris',
                  'propertyName'     => 'pricePerDay',
                  'numberOfDecimals' => 2
               )
            )
         )
      );
   }

   public function getFromDate(){
      return $this->fromDate;
   }

   public function getToDate(){
      return $this->toDate;
   }

   public function getRentalObjectId(){
      return $this->rentalObjectId;
   }

   protected function setPricePerDay($price){
      $this->_validation->validate('pricePerDay', $price);
      $this->pricePerDay = $price;
      $this->setPrice();
   }

   public function setPricePerDayFromRentalObject(RentalObject $rentalObject){
      $this->pricePerDay = $rentalObject->getPricePerDay();
      $this->setPrice();
   }

   private function setPrice(){
      $numberOfDays = $this->getNumberOfDays();
      $this->price  = $numberOfDays * $this->pricePerDay;
   }

   private function getNumberOfDays(){

      if ($this->fromDate && $this->toDate){
         $fromDate = new \DateTime($this->fromDate);
         $toDate   = new \DateTime($this->toDate);
         $result   = $fromDate->diff($toDate)->format('%a') + 1;
      } else{
         $result = 0;
      }

      return $result;
   }
} 