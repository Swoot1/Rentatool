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
use Rentatool\Application\ENFramework\Models\GeneralModel;

class RentalObject extends GeneralModel {
   protected $id;
   protected $userId;
   protected $name;
   protected $available;

   /**
    * Sets the type and length validation on all properties.
    * @return $this
    */
   protected function setUpValidation() {
      $validation = new ValueValidationCollection(array(
                                                     new IntegerValidation(array(
                                                                              'genericName'  => 'Uthyrningsobjektets namn',
                                                                              'propertyName' => 'name'
                                                                           )
                                                     ),
                                                     new BooleanValidation(array(
                                                                              'genericName'  => 'Uthyrningsobjektets tillgänglighetsstatus',
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