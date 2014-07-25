<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 20:10
 */

namespace Rentatool\Application\ENFramework\Helpers\Validation;


use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class EmailValidation extends ValueValidation{

   public function objectValidation($value){
      $this->validateEmail($value);
   }

   /**
    * Check the email so that it is correct.
    * @param $value
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function validateEmail($value){

      // TODO use the regex before the @ behind the @ to validate the site name the same way.
      $result              = preg_match('/^(([a-z\d])|(?:[a-z\d](?:[a-z\-\d]+)?[a-z\d]))@[\w-]+\.\w+$/', $value);
      $valueIsInvalidEmail = $result < 1 || $result === false;

      if ($valueIsInvalidEmail){
         throw new ApplicationException(sprintf('Värdet angivet för %s är en ogiltig email-adress.', $this->genericName));
      }

      return true;
   }
}