<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 08:01
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class OrganizationNumberValidation extends ValueValidation{

   protected function objectValidation($value){

      $this->validateIsOrganizationNumber($value);

      return true;
   }

   private function validateIsOrganizationNumber($organizationNumber){
      $this->checkIsString($organizationNumber);
      $this->checkFormat($organizationNumber);
      $this->checkIsLuhn($organizationNumber);
      // TODO check against register that the company exists.

      return true;
   }

   private function checkIsString($organizationNumber){

      if (!is_string($organizationNumber)){
         throw new ApplicationException(sprintf('Ogiltigt format på %s.', $this->genericName));
      }

      return true;
   }

   private function checkFormat($organizationNumber){

      $isValid = preg_match('/^([\d]{12,12}|[\d]{10,10}){1,1}$/', $organizationNumber);

      if (!$isValid){
         throw new ApplicationException(sprintf('Ogiltigt format på %s.', $this->genericName));
      }

      return true;
   }

   private function checkIsLuhn($organizationNumber){
      $luhnValidation = new LuhnValidation(array('genericName' => $this->genericName, 'propertyName' => $this->propertyName));

      if ($this->isSocialSecurityNumber($organizationNumber)){
         // Since we're saving the social security number with century i.e. 19- we need to strip it to make the luhn check work.
         $luhnValidation->validate(substr($organizationNumber, 2));
      } else{
         $luhnValidation->validate($organizationNumber);
      }

      return true;
   }

   private function isSocialSecurityNumber($organizationNumber){
      return strlen($organizationNumber) === 12;
   }
}