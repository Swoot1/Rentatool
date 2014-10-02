<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 20:10
 */

namespace Application\ENFramework\Helpers\Validation;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class EmailValidation extends ValueValidation{

   public function objectValidation($value){
      $this->validateEmail($value);
   }

   /**
    * Check the email so that it is correct.
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateEmail($value){
      $result              = preg_match('/^(([a-z\d])|(?:[a-z\d](?:[a-z\-\d]+)?[a-z\d]))@(([a-z\d])|(?:[a-z\d](?:[a-z\-\d]+)?[a-z\d]))\.[a-z]+$/', $value);
      $valueIsInvalidEmail = $result < 1 || $result === false;

      if ($valueIsInvalidEmail){
         throw new ApplicationException(sprintf('Värdet angivet för %s är en ogiltig e-postadress.', $this->genericName));
      }

      return true;
   }
}