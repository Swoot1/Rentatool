<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-06-17
 * Time: 20:44
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\BooleanValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class Authorization extends GeneralModel {
   protected $isLoggedIn = false;


   protected function setUpValidation() {
      $this->setValidation(new ValueValidationCollection(array(
                                                            new BooleanValidation(array(
                                                                                     'genericName'  => 'Inloggad-flagga',
                                                                                     'propertyName' => 'isLoggedIn'
                                                                                  )
                                                            )
                                                         )));
   }
}