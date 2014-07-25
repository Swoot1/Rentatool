<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 20:32
 * To change this template use File | Settings | File Templates.
 */
namespace Rentatool\Application\ENFramework\Helpers\Validation;

// TODO remove this class.

class PropertyValidation
{
//    protected $dataTypeValidation;
    protected $minLength = 1;
    protected $maxLength = null;
    protected $genericName;
    protected $propertyName;
    protected $allowNull = false;

    public function __construct($data)
    {
        foreach ($data as $propertyName => $value) {
            $this->$propertyName = $value;
        }
    }

    public function validate($value)
    {
    }

    /**
     * Checks if the data is set
     * @param $data
     * @return bool
     */
    public function hasMatchingData($data)
    {
        $result = true;

        foreach ($data as $propertyName => $value) {
            if ($this->$propertyName !== $value) {
                $result = false;
                break;
            }
        }

        return $result;
    }

}