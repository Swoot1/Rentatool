<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:44
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\BooleanValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\TextValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class RentalObject extends GeneralModel {
   protected $id;
   protected $userId;
   protected $name;
   protected $available;
   protected $pricePlanCollection;

   /**
    * Sets the type and length validation on all properties.
    * @return $this
    */
   protected function setUpValidation() {
      $validation = new ValueValidationCollection(array(
                                                     new IntegerValidation(array(
                                                                              'genericName'  => 'uthyrningsobjektets id',
                                                                              'propertyName' => 'id'
                                                                           )
                                                     ),
                                                     new IntegerValidation(array(
                                                                              'genericName'  => 'uthyrningsobjektets användarid',
                                                                              'propertyName' => 'userId'
                                                                           )
                                                     ),
                                                     new TextValidation(array(
                                                                             'genericName'  => 'uthyrningsobjektets namn',
                                                                             'propertyName' => 'name',
                                                                             'maxLength'    => 30
                                                                          )
                                                     ),
                                                     new BooleanValidation(array(
                                                                              'genericName'  => 'uthyrningsobjektets tillgänglighetsstatus',
                                                                              'propertyName' => 'available'
                                                                           )
                                                     )
                                                  ));
      $this->setValidation($validation);

      return $this;
   }

   protected function setUpDefaultValues() {
      $defaultValues = array(
         'id'        => null,
         'name'      => null,
         'available' => 1
      );

      $this->setDefaultValues($defaultValues);
   }
}