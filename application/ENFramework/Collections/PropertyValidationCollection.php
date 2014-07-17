<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Collections;


class PropertyValidationCollection
{

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validates the properties validation rules.
     * @param $name
     * @param $value
     * @return bool
     */
    public function validate($name, $value)
    {
        $validations = $this->where(array('propertyName' => $name));
        foreach ($validations as $validation) {
            $validation->validate($value);
        }

        return true;
    }

    private function where(array $data)
    {
        $result = array();

        foreach ($this->data as $model) {
            $isMatch = true;

            if ($model->hasMatchingData($data) === false) {
                $isMatch = false;
            }

            if ($isMatch) {
                $result[] = $model;
            }
        }

        return $result;
    }
}