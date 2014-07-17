<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:38
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\PropertyValidationCollection;
use Rentatool\Application\ENFramework\Models\GeneralModel;
use Rentatool\Application\ENFramework\Helpers\PropertyValidation;

class CaughtFish extends GeneralModel
{
    protected $id;
    protected $fishId;
    protected $userId;
    protected $weight;
    protected $measurement;
    protected $fishName;

    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    /**
     * Sets the type and length validation on all properties.
     * @return $this
     */
    protected function setUpValidation()
    {
        $validation = new PropertyValidationCollection(array(
            'id' => new PropertyValidation(array(
                        'dataType' => 'integer',
                        'genericName' => 'ID:t för fångad fisk')
                ),
            'fishId' => new PropertyValidation(array(
                        'dataType' => 'integer',
                        'genericName' => 'ID:t för fisktyp')
                ),

        ));
        $this->setValidation($validation);
        return $this;
    }

    /**
     *
     */
    protected function setUpNoDBProperties()
    {
        $noDBProperties = array(
            'fishName'
        );

        $this->setNoDBProperties($noDBProperties);
    }

    protected function setUpDefaultValues()
    {
        $defaultValues = array(
            'id' => null,
            'fishId' => null,
            'userId' => null,
            'weight' => null,
            'measurement' => null,
            'fishName' => null
        );

        $this->setDefaultValues($defaultValues);
    }
}