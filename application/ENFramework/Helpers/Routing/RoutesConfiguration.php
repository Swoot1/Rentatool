<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

use Rentatool\Application\ENFramework\Helpers\Routing\RouteCollection;

$routes = array();

$routes['rentalobjects'] = array(
   'controllerName' => 'RentalObjectController'
);

$routes['authorization'] = array(
   'controllerName'        => 'AuthorizationController',
   'requiresAuthorization' => false
);

$routes['users'] = array(
   'controllerName' => 'UserController',
   'requiresAuthorization' => false
);

$routes['databases'] = array(
   'controllerName'        => 'DatabaseController',
   'requiresAuthorization' => false
);

return new RouteCollection($routes);