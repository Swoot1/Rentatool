<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 17:10
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Collections;


class RequestMethodCollection {

    private $data = array('PUT', 'POST', 'GET', 'DELETE');

    private function getData(){
        return $this->data;
    }

    /**
     * @param $methodName
     * @return bool
     */
    public function isValidRequestMethod($methodName){
        return array_search($methodName, $this->getData()) !== false;
    }
}