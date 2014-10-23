<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 19:56
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class IntegerValidation extends ValueValidation{

   protected $allowNegativeInteger = false;
   protected $lowerLimit = null;
   protected $upperLimit = null;

   public function objectValidation($value){
      $this->validateIsNumber($value);
      $this->validateIsInteger($value);
      $this->validateIsAllowedNegativeInteger($value);
      $this->validateUpperLimit($value);
      $this->validateLowerLimit($value);

      return true;
   }

   /**
    * Validate that we're dealing with an actual number and not a string or the like.
    * @param $value
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsNumber($value){
      $valueIsNotANumber = is_numeric($value) == false;
      if ($valueIsNotANumber){
         throw new ApplicationException(sprintf('%s måste bestå av siffror.', $this->genericName));
      }

      return true;
   }

   /**
    * Validate that the number is an integer.
    * @param $value
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsInteger($value){
      $valueIsFloat = (int)$value !== $value;
      if ($valueIsFloat){
         throw new ApplicationException(sprintf('%s måste bestå av siffror.', $this->genericName));
      }

      return true;
   }

   /**
    * If the integer is negative validate that it's allowed to be that.
    * @param $value
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsAllowedNegativeInteger($value){
      $valueIsUnAllowedNegativeNumber = $this->allowNegativeInteger == false && $value < 0;
      if ($valueIsUnAllowedNegativeNumber){
         throw new ApplicationException(sprintf('%s får inte vara negativt.', $this->genericName));
      }

      return true;
   }

   private function validateUpperLimit($value){

      if($this->upperLimit && $value > $this->upperLimit){
         throw new ApplicationException(sprintf('%s måste vara mindre än %s.', $this->genericName, $this->upperLimit));
      }

      return true;
   }

   private function validateLowerLimit($value){

      if($this->lowerLimit && $value < $this->lowerLimit){
         throw new ApplicationException(sprintf('%s måste vara större än %s.', $this->genericName, $this->lowerLimit));
      }

      return true;
   }
}