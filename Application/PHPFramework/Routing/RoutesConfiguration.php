<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */


namespace Application\PHPFramework\Routing;

use Application\Collections\RequestMethodCollection;
use Application\PHPFramework\AccessRules\AdministrativeAccessRule;
use Application\PHPFramework\AccessRules\AuthorizedAccessRule;

$routes = array();

$routes['rentalobjects'] = array(
   'controllerName'          => 'RentalObjectController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['inactivaterentalobjects'] = array(
   'controllerName'          => 'InactivateRentalObjectController',
   'requestMethodCollection' => new RequestMethodCollection(array('PUT')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['rentalobjectpayments'] = array(
   'controllerName'          => 'RentalObjectPaymentController',
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
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
   'accessRule'              => new AdministrativeAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
   'subRoutesCollection'     => new SubRouteCollection(
         array(
            'currentUser'  => array(
               'controllerName'          => 'UserController',
               'accessRule'              => new AuthorizedAccessRule(),
               'requestMethodCollection' => new RequestMethodCollection(array('GET')),
               'subRoutesCollection'     => new SubRouteCollection(array())
            ),
            'confirmemail' => array(
               'controllerName'          => 'UserController',
               'requestMethodCollection' => new RequestMethodCollection(array('GET')),
               'subRoutesCollection'     => new SubRouteCollection(array())
            )
         )
      )
);

$routes['signups'] = array(
   'controllerName'          => 'SignUpController',
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
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

$routes['confirmrentperiods'] = array(
   'controllerName'          => 'ConfirmRentPeriodController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('PUT')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['rentperiodcalculators'] = array(
   'controllerName'          => 'RentPeriodCalculatorController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['unavailablerentperiods'] = array(
   'controllerName'          => 'UnavailableRentPeriodController',
   'accessRule'              => new AuthorizedAccessRule(),
   'requestMethodCollection' => new RequestMethodCollection(array('GET')),
   'subRoutesCollection'     => new SubRouteCollection()
);

$routes['menuitems'] = array(
   'controllerName'          => 'MenuController',
   'requestMethodCollection' => new RequestMethodCollection(array('GET')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);

$routes['files'] = array(
   'controllerName'          => 'FileController',
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);

$routes['index'] = array(
   'controllerName'          => 'IndexHTMLController',
   'requestMethodCollection' => new RequestMethodCollection(array('GET')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);

$routes['resetpasswords'] = array(
   'controllerName'          => 'ResetPasswordController',
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);

$routes['passwords'] = array(
   'controllerName'          => 'PasswordController',
   'requestMethodCollection' => new RequestMethodCollection(array('POST')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);

$routes['rentperiodconfirmations'] = array(
   'controllerName'          => 'RentPeriodConfirmationController',
   'requestMethodCollection' => new RequestMethodCollection(array('GET')),
   'subRoutesCollection'     => new SubRouteCollection(array())
);


return new RouteCollection($routes);
