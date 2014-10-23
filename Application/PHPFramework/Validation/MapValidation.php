<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 23/10/14
 * Time: 18:26
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class MapValidation extends ValueValidation{

   protected $map = array();

   protected function objectValidation($value){
      $this->validateExistsInMap($value);

      return true;
   }

   private function validateExistsInMap($value){
      $exists = array_search($value, $this->map);

      if($exists === false){
         throw new ApplicationException(sprintf('%s innehåller ett otillåtet värde.', $this->genericName));
      }

      return true;
   }
} 