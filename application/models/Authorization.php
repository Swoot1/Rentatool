<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-06-17
 * Time: 20:44
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\PropertyValidationCollection;
use Rentatool\Application\ENFramework\Models\GeneralModel;
use Rentatool\Application\ENFramework\Helpers\PropertyValidation;

class Authorization extends GeneralModel
{
    protected $isLoggedIn = false;


    protected function setUpValidation()
    {
        $this->setValidation(new PropertyValidationCollection(array(
            new PropertyValidation(array(
                    'dataType' => 'boolean',
                    'genericName' => 'Inloggad-flagga',
                    'propertyName' => 'isLoggedIn'
                )
            )
        )));
    }
}