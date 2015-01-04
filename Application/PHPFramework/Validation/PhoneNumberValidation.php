<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 11:24
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class PhoneNumberValidation extends ValueValidation{

   protected function objectValidation($phoneNumber){

      if (!is_string($phoneNumber)){
         throw new ApplicationException(sprintf('Ogiltigt %s.'), $this->genericName);
      }

      $matches = preg_match('/^[0-9]{2,4}(\s|-)?[0-9\s]{2,12}$/', $phoneNumber);

      if (!$matches){
         throw new ApplicationException(sprintf('Ogiltigt %s.', $this->genericName));
      }

      return true;
   }
}