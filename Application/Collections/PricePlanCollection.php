<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 16:29
 */

namespace Application\Collections;


use Application\ENFramework\Collections\GeneralCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\Models\RentalObject;

class PricePlanCollection extends GeneralCollection{
   protected $model = 'Application\Models\PricePlan';

   public function setRentalObjectId(RentalObject $rentalObject){

      foreach($this->data as $key => $pricePlan){
         $this->data[$key] = $pricePlan->setRentalObjectId($rentalObject);
      }

      return $this;
   }

   public function getPricePlanByTimeUnitId($timeUnitId){
      $result = false;

      foreach($this->data as $pricePlan){
         if($pricePlan->getTimeUnitId() === $timeUnitId){
            $result = $pricePlan;
         }
      }

      return $result;
   }

   public function validateNumberOfPricePlans(){

      if(count($this->data) < 1){
         throw new ApplicationException('Ange minst en prisplan. T.ex. 100 kr/timme.');
      }

      return true;
   }
}