<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:44
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\PropertyValidationCollection;
use Rentatool\Application\ENFramework\Models\GeneralModel;
use Rentatool\Application\ENFramework\Helpers\PropertyValidation;

class RentalObject extends GeneralModel
{
    protected $id;
    protected $userId;
    protected $name;
    protected $available;

    /**
     * Sets the type and length validation on all properties.
     * @return $this
     */
    protected function setUpValidation()
    {
        $validation = new PropertyValidationCollection(array(
            new PropertyValidation(array(
                    'dataType' => 'integer',
                    'genericName' => 'Uthyrningsobjektets namn',
                    'propertyName' => 'name'
                )
            ),
            new PropertyValidation(array(
                                      'dataType' => 'boolean',
                                      'genericName' => 'Uthyrningsobjektets tillgänglighetsstatus',
                                      'propertyName' => 'available'
                                   )
            )
        ));
        $this->setValidation($validation);
        return $this;
    }

    protected function setUpDefaultValues()
    {
        $defaultValues = array(
            'id' => null,
            'name' => null,
            'available' => 1
        );

        $this->setDefaultValues($defaultValues);
    }
}