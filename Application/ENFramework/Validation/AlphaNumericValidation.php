<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 09:42
 */

namespace Application\ENFramework\Validation;


use Application\ENFramework\ErrorHandling\Exceptions\ApplicationException;

class AlphaNumericValidation extends ValueValidation{

   protected $minLength = 1;
   protected $maxLength = null;

   protected function objectValidation($value){
      $this->validateAlphaNumeric($value);
   }

   private function validateAlphaNumeric($value){
      $result                     = preg_match(sprintf('/^[a-zåäöA-ZÅÄÖ0-9]{%s,%s}$/', $this->minLength, $this->maxLength), $value);
      $isInvalidAlphaNumericValue = $result === 0 || $result === false;

      if ($isInvalidAlphaNumericValue){
         throw new ApplicationException(sprintf('%s måste vara alfanumeriskt.', $this->genericName));
      }

      return true;
   }
}