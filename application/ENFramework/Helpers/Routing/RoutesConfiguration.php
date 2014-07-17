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

$routes['caughtfish'] = array(
   'controllerName' => 'CaughtFishController'
);

$routes['fish'] = array(
   'controllerName' => 'FishController'
);

$routes['authorization'] = array(
   'controllerName'        => 'AuthorizationController',
   'requiresAuthorization' => false
);

$routes['user'] = array(
   'controllerName' => 'UserController'
);


return new RouteCollection($routes);