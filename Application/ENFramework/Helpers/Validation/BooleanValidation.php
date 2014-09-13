<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 13:32
 */

namespace Application\ENFramework\Helpers\Validation;

use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class BooleanValidation extends ValueValidation {

   protected function objectValidation($value) {
      $this->validateIsBoolean($value);
      return true;
   }

   private function validateIsBoolean($value) {

      $isInvalidBoolean = $value !== true && $value !== false;
      if ($isInvalidBoolean) {
         throw new ApplicationException(sprintf('%s måste vara en boolean.', $this->genericName));
      }

      return true;
   }
}