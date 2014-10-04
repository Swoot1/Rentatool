<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:11
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class DateTimeValidation extends ValueValidation{
   public function objectValidation($value){
      $this->validateDate($value);

      return true;
   }

   private function validateDate($value){
      $isDate        = preg_match('/^\d{4,4}-\d\d-\d\d \d\d:\d\d:\d\d$/', $value);
      $formattedDate = $isDate ? new \DateTime($value) : false;
      $isInvalidDate = $formattedDate === false || $formattedDate->format('Y-m-d H:i:s') !== $value;

      if ($isInvalidDate){
         throw new ApplicationException(sprintf('Ogiltigt datum angivet för %s.', $this->genericName));
      }

      return true;
   }
}