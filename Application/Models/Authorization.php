<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-06-17
 * Time: 20:44
 */

namespace Application\Models;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\BooleanValidation;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\IntegerValidation;

class Authorization extends GeneralModel{
   protected $isLoggedIn = false;
   protected $userId;


   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                            new BooleanValidation(array(
                                                                                     'genericName'  => 'Inloggad-flagga',
                                                                                     'propertyName' => 'isLoggedIn'
                                                                                  )
                                                            ),
                                                            new IntegerValidation(array(
                                                                                       'genericName'  => 'Användar-id',
                                                                                       'propertyName' => 'userId'
                                                                                  )
                                                            )
                                                         )));
   }
}