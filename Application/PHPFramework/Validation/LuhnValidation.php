<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 08:35
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class LuhnValidation extends ValueValidation{

   protected function objectValidation($value){
      return $this->validateIsLuhn($value);
   }

   private function validateIsLuhn($number){

      if (!is_numeric($number)){
         throw new ApplicationException(sprintf('Ange ett numeriskt värde för %s.', $this->genericName));
      }

      $digits     = str_split($number);
      $digits     = array_reverse($digits);
      $checkSum   = 0;

      foreach ($digits as $key => $digit){
         $multiplier = ($key + 1) % 2 ? 1 : 2;
         $sum = $digit *  $multiplier;

         if ($sum > 9){
            $checkSum += 1 + $sum % 10;
         } else{
            $checkSum += $sum;
         }
      }

      if ($checkSum % 10){
         throw new ApplicationException(sprintf('Ogiltigt format på %s.', $this->genericName));
      }

      return true;
   }
}