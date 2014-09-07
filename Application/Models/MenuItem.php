<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:25
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\TextValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class MenuItem extends GeneralModel{

   protected $label;
   protected $callback;

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
