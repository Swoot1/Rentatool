<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Validation\Collections;

class ValueValidationCollection{

   protected $data;

   public function __construct(array $data = array()){
      foreach ($data as $key => $validation){
         $propertyName        = $validation->getPropertyName();
         $data[$propertyName] = $validation;
         unset($data[$key]);
      }

      $this->data = $data;
   }

   /**
    * Validates the properties validation rules.
    * @param $name
    * @param $value
    * @return bool
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\ApplicationException
    */
   public function validate($name, $value){
      if (array_key_exists($name, $this->data)){
         $this->data[$name]->validate($value);
      }

      return true;
   }
}