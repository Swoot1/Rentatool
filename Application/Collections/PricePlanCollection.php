<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 16:29
 */

namespace Rentatool\Application\Collections;


use Rentatool\Application\ENFramework\Collections\GeneralCollection;

class PricePlanCollection extends GeneralCollection{
   protected $model = 'Rentatool\Application\Models\PricePlan';

   public function getPricePlanByTimeUnitId($timeUnitId){
      $result = false;

      foreach($this->data as $pricePlan){
         if($pricePlan->getTimeUnitId() === $timeUnitId){
            $result = $pricePlan;
         }
      }

      return $result;
   }
}