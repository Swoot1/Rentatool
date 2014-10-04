<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 20:10
 */

namespace Application\ENFramework\Validation;

use Application\ENFramework\ErrorHandling\Exceptions\ApplicationException;

class FloatValidation extends ValueValidation{

   protected $numberOfDecimals = 2;
   protected $allowNegativeInteger = false;

   public function objectValidation($value){
      $this->validateIsNumber($value);
      $this->validateIsFloat($value);
      $this->validateIsAllowedNegativeFloat($value);
      $this->validateNumberOfDecimals($value);
   }

   /**
    * Validate that we're dealing with an actual number and not a string or the like.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsNumber($value){
      $valueIsNotANumber = is_numeric($value) === false;
      if ($valueIsNotANumber){
         throw new ApplicationException(sprintf('%s måste vara ett decimaltal.', $this->genericName));
      }

      return true;
   }

   /**
    * Validate that the number is actually a float and not a number string or anything else silly.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsFloat($value){
      $valueIsNotAFloat = (float)$value != $value || is_string($value);
      if ($valueIsNotAFloat){
         throw new ApplicationException(sprintf('%s måste vara ett decimaltal.', $this->genericName));
      }

      return true;
   }

   /**
    * If the integer is negative validate that it's allowed to be that.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateIsAllowedNegativeFloat($value){
      $valueIsUnAllowedNegativeNumber = $this->allowNegativeInteger === false && $value < 0;
      if ($valueIsUnAllowedNegativeNumber){
         throw new ApplicationException(sprintf('%s får inte vara negativt.', $this->genericName));
      }

      return true;
   }

   /**
    * Validates that the correct number of decimals is given.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateNumberOfDecimals($value){
      $valueAsString                 = (string)$value;
      $actualNumberOfDecimals        = strlen(substr(strrchr($valueAsString, "."), 1));
      $valueHasWrongNumberOfDecimals = $this->numberOfDecimals < $actualNumberOfDecimals;

      if ($valueHasWrongNumberOfDecimals){
         throw new ApplicationException(sprintf('Ange %s eller färre decimaler för %s.', $this->numberOfDecimals, $this->genericName));
      }

      return true;
   }
}