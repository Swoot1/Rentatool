<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 10:07
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class CityValidation extends ValueValidation{

   protected function objectValidation($value){

      if (!is_string($value)){
         throw new ApplicationException(sprintf('Ogiltig %s.'), $this->genericName);
      }

      $matches = preg_match('/^[a-zåäö\s]{1,100}$/i', $value); // TODO not working with Åtorp

      if (!$matches){
         throw new ApplicationException('Ogiltig stad.');
      }

      return true;
   }
}