<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Helpers\Routing\RouteCollection;

$routes = array();

$routes['rentalobjects'] = array(
   'controllerName'          => 'RentalObjectController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
);

$routes['authorization'] = array(
   'controllerName'          => 'AuthorizationController',
   'requiresAuthorization'   => false,
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
);

$routes['users'] = array(
   'controllerName'          => 'UserController',
   'requiresAuthorization'   => false,
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
);

$routes['databases'] = array(
   'controllerName'          => 'DatabaseController',
   'requiresAuthorization'   => false,
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
);

return new RouteCollection($routes);