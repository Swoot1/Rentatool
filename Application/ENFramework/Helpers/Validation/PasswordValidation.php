<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 09:44
 */

namespace Application\ENFramework\Helpers\Validation;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class PasswordValidation extends ValueValidation {

   public function objectValidation($value) {
      $this->validatePassword($value);
   }

   private function validatePassword($value) {

      $result = preg_match('/^[A-ZÅÄÖa-zåäö0-9!#\\\\$%&\'\(\)\*\+,\.\/:;<=>\?@^_`\{|\}~\[\]\-]{6,64}$/', $value);
      $isInvalidPassword = $result === 0 || $result === false;

      if ($isInvalidPassword) {
         throw new ApplicationException('Ogiltigt lösenord.');
      }

      return true;
   }
} 