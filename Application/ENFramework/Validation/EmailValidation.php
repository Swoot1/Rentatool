<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 20:10
 */

namespace Application\ENFramework\Validation;


use Application\ENFramework\ErrorHandling\Exceptions\ApplicationException;

class EmailValidation extends ValueValidation{

   public function objectValidation($value){
      $this->validateEmail($value);
   }

   /**
    * Check the email so that it is correct.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateEmail($value){
      $valueIsInvalidEmail = filter_var($value, FILTER_VALIDATE_EMAIL) === false;

      if ($valueIsInvalidEmail){
         throw new ApplicationException(sprintf('Värdet angivet för %s är en ogiltig e-postadress.', $this->genericName));
      }

      return true;
   }
}