<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Helpers\AccessRules\AuthorizedAccessRule;
use Rentatool\Application\ENFramework\Helpers\Routing\RouteCollection;
use Rentatool\Application\ENFramework\Helpers\Routing\SubRouteCollection;

$routes = array();

$routes['rentalobjects'] = array(
   'controllerName'          => 'RentalObjectController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['authorization'] = array(
   'controllerName'          => 'AuthorizationController',
   'requestMethodCollection' => new RequestMethodCollection(array()),
   'subRoutesCollection'     => new SubRouteCollection(
      array(
           'login'  => array(
              'controllerName'          => 'AuthorizationController',
              'requestMethodCollection' => new RequestMethodCollection(array('POST')),
              'subRoutesCollection'     => new SubRouteCollection(array())),
           'logout' => array(
              'controllerName'          => 'AuthorizationController',
              'requestMethodCollection' => new RequestMethodCollection(array('GET')),
              'subRoutesCollection'     => new SubRouteCollection())
      )
   )
);

$routes['users'] = array(
   'controllerName'          => 'UserController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['databases'] = array(
   'controllerName'          => 'DatabaseController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection(
      array(
           'createwithseeds' => array(
              'controllerName'          => 'DatabaseController',
              'requiresAuthorization'   => false,
              'requestMethodCollection' => new RequestMethodCollection(array('POST')),
              'subRoutesCollection'     => new SubRouteCollection())
      )
   )
);

$routes['rentperiods'] = array(
   'controllerName'          => 'RentPeriodController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['rentperiodcalculators'] = array(
   'controllerName'          => 'RentPeriodCalculatorController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['usergroups'] = array(
   'controllerName'          => 'UserGroupController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection(
      array(
           'addMember'    => array(
              'controllerName'          => 'UserGroupController',
              'accessRule'              => new AuthorizedAccessRule(),
              'requestMethodCollection' => new RequestMethodCollection(array('POST')),
              'subRoutesCollection'     => new SubRouteCollection(array())
           ),
           'removeMember' => array(
              'controllerName'          => 'UserGroupController',
              'accessRule'              => new AuthorizedAccessRule(),
              'requestMethodCollection' => new RequestMethodCollection(array('POST')),
              'subRoutesCollection'     => new SubRouteCollection(array())
           )
      ))
);

$routes['timeunits'] = array(
   'controllerName'          => 'TimeUnitController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['priceplans'] = array(
   'controllerName'          => 'PricePlanController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('POST', 'DELETE')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['unavailablerentperiods'] = array(
   'controllerName'          => 'UnavailableRentPeriodController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

return new RouteCollection($routes);
