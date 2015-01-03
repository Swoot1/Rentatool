<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/01/15
 * Time: 10:06
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class AddressValidation extends ValueValidation{

   protected function objectValidation($value){
      $matches = preg_match('/^[a-zåäö\d\s]{1,100}$/i', $value);

      if (!$matches){
         throw new ApplicationException('Ogiltig adress.');
      }

      return true;
   }
} 