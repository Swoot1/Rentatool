<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 18:07
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\DateTimeValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\FloatValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class RentPeriod extends GeneralModel{
   protected $id;
   protected $rentalObjectId;
   protected $renterId;
   protected $fromDate;
   protected $toDate;
   protected $price;
   protected $_pricePlanCollection;
   protected $_rentPeriodPriceCalculator;

   public function __construct(array $data = array(), RentPeriodPriceCalculator $rentPeriodPriceCalculator){
      $this->_rentPeriodPriceCalculator = $rentPeriodPriceCalculator;
      return parent::__construct($data);
   }

   // TODO add validation so that the from date is not after the to date.
   public function setUpValidation(){
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
                  'genericName'  => 'Pris',
                  'propertyName' => 'price',
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

   public function setPricePlanCollection(PricePlanCollection $pricePlanCollection){
      $this->_pricePlanCollection = $pricePlanCollection;
      $this->price = $this->_rentPeriodPriceCalculator->getCalculatedPrice($this, $this->_pricePlanCollection);

      return $this;
   }
} 