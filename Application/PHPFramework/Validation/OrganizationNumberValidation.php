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
      $this->checkIsInteger($organizationNumber);
      $this->checkFormat($organizationNumber);
      $this->checkIsLuhn($organizationNumber);

      return true;
   }

   private function checkIsInteger($organizationNumber){
      $integerValidation = new IntegerValidation(array('genericName' => $this->genericName, 'propertyName' => $this->propertyName));
      $integerValidation->validate($organizationNumber);

      return true;
   }

   private function checkFormat($organizationNumber){
      $isValid = preg_match('/$[0-9]{12, 12}^/', (string)$organizationNumber);

      if (!$isValid){
         throw new ApplicationException(sprintf('Ogiltigt format på %s', $this->genericName));
      }

      return true;
   }

   private function checkIsLuhn($organizationNumber){
      $luhnValidation = new LuhnValidation(array('genericName' => $this->genericName, 'propertyName' => $this->propertyName));
      $luhnValidation->validate($organizationNumber);

      return true;
   }
}