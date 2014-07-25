<?php
/**
 * User: Elin
 * Date: 2014-07-25
 * Time: 16:38
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests\Routing;


use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Helpers\Routing\RouteCollection;

class RouteCollectionTest extends \PHPUnit_Framework_TestCase {

   /**
    * This should work well and return the matching route.
    */
   public function testGetRouteNormalUseCase() {
      $routes          = array();
      $routes['users'] = array(
         'controllerName'          => 'UserController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT', 'POST', 'DELETE', 'GET'))
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('users', 'POST');
      $route       = $routeCollection->getRoute($requestMock);

      $this->assertEquals('UserController', $route->getController());
   }

   /**
    * @param $resource
    * @param $requestMethod
    * @return \PHPUnit_Framework_MockObject_MockObject
    */
   private function getUserRequestMock($resource, $requestMethod) {
      $requestMock = $this
         ->getMockBuilder('Rentatool\Application\ENFramework\Models\Request')
         ->disableOriginalConstructor()
         ->getMock();

      $requestMock
         ->expects($this->once())
         ->method('getResource')
         ->will($this->returnValue($resource));

      $requestMock
         ->expects($this->once())
         ->method('getRequestMethod')
         ->will($this->returnValue($requestMethod));

      return $requestMock;
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig request method.
    */
   public function testGetRouteWithWrongRequestMethod() {
      $routes          = array();
      $routes['users'] = array(
         'controllerName'          => 'UserController',
         'requiresAuthorization'   => false,
         'requestMethodCollection' => new RequestMethodCollection(array('PUT'))
      );

      $routeCollection = new RouteCollection($routes);

      $requestMock = $this->getUserRequestMock('users', 'POST');
      $routeCollection->getRoute($requestMock);
   }
} 