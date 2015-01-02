<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 16:48
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;

class Customer extends GeneralModel {

   protected $name;
   protected $address1;
   protected $address2;
   protected $zipCode;
   protected $city;

   public function setUpValidation() {
      $this->_validation = new ValueValidationCollection(array());
   }

}