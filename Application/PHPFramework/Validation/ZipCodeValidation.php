<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 09:33
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class ZipCodeValidation extends ValueValidation{

   protected function objectValidation($zipCode){

      $this->validateIsZipCode($zipCode);

      return true;
   }

   private function validateIsZipCode($zipCode){

      if (!is_string($zipCode)){
         throw new ApplicationException(sprintf('Ogiltigt %s.', $this->genericName));
      }

      $matches = preg_match('/^[\d]{3,3}\s[\d]{2,2}$/', $zipCode);

      if (!$matches){
         throw new ApplicationException(sprintf('Ogiltigt %s.', $this->genericName));
      }

      return true;
   }
} 