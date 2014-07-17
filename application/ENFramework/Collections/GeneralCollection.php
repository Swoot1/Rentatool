<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 20:28
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Collections;

class GeneralCollection
{

    protected $data = array();
    protected $model;

    public function __construct(array $data)
    {
        foreach ($data as $modelData) {
            if ($modelData instanceof $this->model) {
                $this->data[] = $modelData;
            } else {
                $this->data[] = new $this->model($modelData);
            }
        }

        return $this;
    }

    public function toArray()
    {
        $result = array();

        foreach ($this->data as $model) {
            $result[] = $model->toArray();
        }

        return $result;
    }
}