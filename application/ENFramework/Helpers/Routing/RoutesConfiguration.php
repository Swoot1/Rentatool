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

$routes[] = array(
    'resource' => 'caughtfish',
    'controllerName' => 'CaughtFishController'
);

$routes[] = array(
    'resource' => 'fish',
    'controllerName' => 'FishController'
);

$routes[] = array(
    'resource' => 'authorization',
    'controllerName' => 'AuthorizationController',
    'requiresAuthorization' => false
);

$routes[] = array(
    'resource' => 'user',
    'controllerName' => 'UserController'
);

return new RouteCollection($routes);