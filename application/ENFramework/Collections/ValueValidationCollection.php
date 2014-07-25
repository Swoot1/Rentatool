<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Collections;


use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class ValueValidationCollection {

   protected $data;

   public function __construct(array $data) {
      foreach ($data as $key => $validation) {
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
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   public function validate($name, $value) {
// TODO just gonna have this commented out until mysql only returning strings is solved.
//      if (array_key_exists($name, $this->data)) {
//         $this->data[$name]->validate($value);
//      } else {
//         throw new ApplicationException(sprintf('Det finns ingen validering för angivet propertynamn %s.', $name));
//      }

      return true;
   }
}