<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 20:32
 * To change this template use File | Settings | File Templates.
 */
namespace Rentatool\Application\ENFramework\Helpers;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

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
        $this->validateNull($value);
        $this->validateMinLength($value);
        $this->validateMaxLength($value);
    }

    /**
     * @param $value
     * @return bool
     * @throws ApplicationException
     */
    private function validateNull($value)
    {
        if ($value === null && $this->allowNull === false) {
            throw new ApplicationException(sprintf('Ange ett värde för %s.', $this->genericName));
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     * @throws ApplicationException
     */
    private function validateMinLength($value)
    {
        if (strlen($value) < $this->minLength) {
            throw new ApplicationException(sprintf('%s måste vara minst %s tecken långt.', $this->genericName, $this->minLength));
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     * @throws ApplicationException
     */
    private function validateMaxLength($value)
    {
        if ($this->maxLength && strlen($value > $this->maxLength)) {
            throw new ApplicationException(sprintf('%s får vara högst %s långt.', $this->genericName, $this->maxLength));
        }

        return true;
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