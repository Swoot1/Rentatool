<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 20:59
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers;

use Application\Collections\RequestMethodCollection;

class RequestDispatcher
{

    private $_serverArray;
    private $requestModel;

    public function __construct()
    {
        $this->_serverArray = $_SERVER;
        $requestMethodCollection = new RequestMethodCollection(array('PUT', 'POST', 'GET', 'DELETE'));
        $requestBuilder = new RequestBuilder($_SERVER, $requestMethodCollection);
        $this->requestModel = $requestBuilder->build();
    }

    public function getRequestModel()
    {
        return $this->requestModel;
    }
}