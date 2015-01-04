<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 19:57
 */

namespace Application\PHPFramework\Validation;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

abstract class ValueValidation{

   protected $genericName;
   protected $propertyName;
   protected $allowNull = false;

   /**
    * @param array $data
    */
   public function __construct(array $data){

      foreach ($data as $key => $value){
         $this->$key = $value;
      }

      return $this;
   }

   public function getPropertyName(){
      return $this->propertyName;
   }

   public function validate($value){

      if (!($this->allowNull && $value === null)){
         $this->validateNull($value);
         $this->objectValidation($value);
      }

      return true;
   }

   abstract protected function objectValidation($value);

   /**
    * @param $value
    * @return bool
    * @throws ApplicationException
    */
   private function validateNull($value){
      if ($this->allowNull === false && $value === null){
         throw new ApplicationException(sprintf('Ange ett värde för %s.', $this->genericName));
      }

      return true;
   }
} 