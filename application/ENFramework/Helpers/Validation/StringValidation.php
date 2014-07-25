<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 19:56
 */

namespace Rentatool\Application\ENFramework\Helpers\Validation;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class StringValidation extends ValueValidation{

   protected $minLength = 1;
   protected $maxLength = null;


   public function objectValidation($value){
      // TODO should validate the characters as well.
      $this->validateMinLength($value);
      $this->validateMaxLength($value);

      return true;
   }

   /**
    * @param $value
    * @return bool
    * @throws ApplicationException
    */
   private function validateMinLength($value){
      if (mb_strlen($value) < $this->minLength){
         throw new ApplicationException(sprintf('%s måste vara minst %s tecken långt.', $this->genericName, $this->minLength));
      }

      return true;
   }

   /**
    * @param $value
    * @return bool
    * @throws ApplicationException
    */
   private function validateMaxLength($value){
      if ($this->maxLength && mb_strlen($value) > $this->maxLength){
         throw new ApplicationException(sprintf('%s får vara högst %s tecken långt.', $this->genericName, $this->maxLength));
      }

      return true;
   }
}