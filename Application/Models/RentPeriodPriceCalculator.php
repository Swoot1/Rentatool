<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 26/08/14
 * Time: 14:51
 */

namespace Application\Models;


use Application\Collections\PricePlanCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class RentPeriodPriceCalculator{

   public function getCalculatedPrice(RentPeriod $rentPeriod, PricePlanCollection $pricePlanCollection){
      $fromDate = new \DateTime($rentPeriod->getFromDate());
      $toDate   = new \DateTime($rentPeriod->getToDate());

      if ($this->isYears($fromDate, $toDate) && $pricePlan = $pricePlanCollection->getPricePlanByTimeUnitId(5)){
         $number = ($toDate->format('y') - $fromDate->format('y'));
      } elseif ($this->isCalendarMonths($fromDate, $toDate) && $pricePlan = $pricePlanCollection->getPricePlanByTimeUnitId(4)){
         $number = ($toDate->format('y') - $fromDate->format('y')) * 12 + $toDate->format('m') - $fromDate->format('m');
      } elseif ($this->isWeeks($fromDate, $toDate) && $pricePlan = $pricePlanCollection->getPricePlanByTimeUnitId(3)){
         $number = $fromDate->diff($toDate)->days/7;
      } elseif ($this->isDays($fromDate, $toDate) && $pricePlan = $pricePlanCollection->getPricePlanByTimeUnitId(2)){
         $number = $result = $fromDate->diff($toDate)->format('%d');
      } elseif ($this->isHours($fromDate, $toDate) && $pricePlan = $pricePlanCollection->getPricePlanByTimeUnitId(1)){
         $diff   = $fromDate->diff($toDate);
         $hours  = $diff->h;
         $number = $hours + ($diff->days * 24);
      } else{
         throw new ApplicationException('Hittade ingen prisplan som matchar vald tidsperiod.');
      }

      return $number * $pricePlan->getPrice();
   }

   private function isCalendarMonths(\DateTime $fromDate, \DateTime $toDate){

      $isFromFirstDayInMonth = $fromDate->format('Y-m-d H:i:s') === $fromDate->format('Y-m-01 00:00:00');
      $isToLastDayInMonth    = $toDate->format('Y-m-d H:i:s') === $toDate->format('Y-m-01 00:00:00');

      return $isFromFirstDayInMonth && $isToLastDayInMonth;
   }

   private function isWeeks(\DateTime $fromDate, \DateTime $toDate){
      return $fromDate->format('D') === 'Mon' && $fromDate->format('Y-m-d H:i:s') === $fromDate->format('Y-m-d 00:00:00') && $toDate->format('D') === 'Mon' && $toDate->format('Y-m-d H:i:s') === $toDate->format('Y-m-d 00:00:00');
   }

   private function isDays(\DateTime $fromDate, \DateTime $toDate){
      $isStartOfDay = $fromDate->format('Y-m-d H:i:s') === $fromDate->format('Y-m-d 00:00:00');
      $isEndOfDay   = $toDate->format('Y-m-d H:i:s') === $toDate->format('Y-m-d 00:00:00');

      return $isStartOfDay && $isEndOfDay;
   }

   private function isYears(\DateTime $fromDate, \DateTime $toDate){
      $isTheSameDay = $fromDate->format('m-d H:i:s') === $toDate->format('m-d 00:00:00');

      return $isTheSameDay && $toDate->format('Y-m-d H:i:s') === $toDate->format('Y-m-d 00:00:00');
   }

   private function isHours(\DateTime $fromDate, \DateTime $toDate){
      return $fromDate->format('Y-m-d H:i:s') === $fromDate->format('Y-m-d H:00:00') && $toDate->format('Y-m-d H:i:s') === $toDate->format('Y-m-d H:00:00');
   }
} 