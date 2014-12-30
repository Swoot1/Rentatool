<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:58
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Collections;

use Application\PHPFramework\Collections\GeneralCollection;

class RentalObjectCollection extends GeneralCollection{
    protected $model = 'Application\Models\RentalObject';

   /**
    * @param $applyFunction
    * @return $this
    */
   public function map($applyFunction){
      foreach($this->data as $key => $rentalObjectModel){
         $this->data[$key] = call_user_func($applyFunction, $rentalObjectModel);
      }

      return $this;
   }
}