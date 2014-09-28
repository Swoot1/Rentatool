<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:25
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\TextValidation;
use Application\ENFramework\Models\GeneralModel;

class MenuItem extends GeneralModel{

   protected $label;
   protected $callback;
   protected $accessRule;

   public function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
              new TextValidation(array(
                                      'propertyName' => 'label',
                                      'genericName'  => 'Menytext'
                                 )),
              new TextValidation(array(
                                      'propertyName' => 'callback',
                                      'genericName'  => 'Callback'
                                 ))
         )
      );
   }

}
