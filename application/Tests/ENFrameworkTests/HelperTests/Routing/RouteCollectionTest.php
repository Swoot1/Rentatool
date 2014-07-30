<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 16:38
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests\Routing;


use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Helpers\Routing\RouteCollection;
use Rentatool\Application\ENFramework\Helpers\Routing\SubRouteCollection;

class RouteCollectionTest extends \PHPUnit_Framework_TestCase {

   /**
    * This should work well and return the matching route.
    */
   public function testGetRouteFromRequestNormalUseCase() {
      $routes          = array();
      $routes['users'] = array(
         'controllerName'          => 'UserController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('users', 'POST');
      $route       = $routeCollection->getRouteFromRequest($requestMock);

      $this->assertEquals('UserController', $route->getController());
   }

   /**
    * @param $resource
    * @param $requestMethod
    * @param $action
    * @return \PHPUnit_Framework_MockObject_MockObject
    */
   private function getUserRequestMock($resource, $requestMethod, $action = false) {
      $requestMock = $this
         ->getMockBuilder('Rentatool\Application\ENFramework\Models\Request')
         ->disableOriginalConstructor()
         ->getMock();

      $requestMock
         ->expects($this->any())
         ->method('getResource')
         ->will($this->returnValue($resource));

      $requestMock
         ->expects($this->any())
         ->method('getRequestMethod')
         ->will($this->returnValue($requestMethod));

      $requestMock
         ->expects($this->any())
         ->method('getAction')
         ->will($this->returnValue($action));

      return $requestMock;
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig request method.
    */
   public function testGetRouteFromRequestWithWrongRequestMethod() {
      $routes          = array();
      $routes['users'] = array(
         'controllerName'          => 'UserController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT'))
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('users', 'POST');
      $routeCollection->getRouteFromRequest($requestMock);
   }

   public function testGetSubRoute() {
      $routes                  = array();
      $routes['authorization'] = array(
         'controllerName'          => 'AuthorizationController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
         'subRoutesCollection'     => new SubRouteCollection(
               array(
                  'login'  => array(
                     'controllerName'          => 'AuthorizationController',
                     'requiresAuthorization'   => false,
                     'requestMethodCollection' => new RequestMethodCollection(array('POST')),
                     'subRoutesCollection'     => new RouteCollection(array())),
                  'logout' => array(
                     'controllerName'          => 'AuthorizationController',
                     'requiresAuthorization'   => false,
                     'requestMethodCollection' => new RequestMethodCollection(array('GET')),
                     'subRoutesCollection'     => new RouteCollection(array()))
               )
            )
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('authorization', 'POST', 'login');
      $route       = $routeCollection->getRouteFromRequest($requestMock);
      $this->assertEquals('AuthorizationController', $route->getController());
   }

   /**
    * Test that a request with wrong request method for the url raises an error.
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig request method.
    */
   public function testGetSubRouteWithWrongRequestMethod() {
      $routes                  = array();
      $routes['authorization'] = array(
         'controllerName'          => 'AuthorizationController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET')),
         'subRoutesCollection'     => new SubRouteCollection(
               array(
                  'login'  => array(
                     'controllerName'          => 'AuthorizationController',
                     'requiresAuthorization'   => false,
                     'requestMethodCollection' => new RequestMethodCollection(array('POST')),
                     'subRoutesCollection'     => new RouteCollection(array())),
                  'logout' => array(
                     'controllerName'          => 'AuthorizationController',
                     'requiresAuthorization'   => false,
                     'requestMethodCollection' => new RequestMethodCollection(array('GET')),
                     'subRoutesCollection'     => new RouteCollection(array()))
               )
            )
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('authorization', 'POST', 'logout');
      $routeCollection->getRouteFromRequest($requestMock);
   }
} 