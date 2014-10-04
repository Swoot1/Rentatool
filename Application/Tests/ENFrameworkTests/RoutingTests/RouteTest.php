<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/10/14
 * Time: 16:49
 */

namespace Tests\PHPFrameworkTests\HelperTests\Routing;


use Application\PHPFramework\AccessRules\AdministrativeAccessRule;
use Application\PHPFramework\Routing\Route;
use Application\PHPFramework\Routing\SubRouteCollection;

class RouteTest extends \PHPUnit_Framework_TestCase{

   public function testGetControllerName(){
      $route = new Route(array('controllerName' => 'UserController'));

      $this->assertEquals('UserController', $route->getController());
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltig request method.
    */
   public function testIsValidRequestMethod(){

      $requestMethodCollectionMock = $this->getMockBuilder('Application\Collections\RequestMethodCollection')
                                          ->disableOriginalConstructor()
                                          ->getMock();

      $requestMethodCollectionMock->expects($this->once())
                                  ->method('isValidRequestMethod')
                                  ->will($this->returnValue(false));

      $requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                          ->disableOriginalConstructor()
                          ->getMock();

      $requestMock->expects($this->once())
                  ->method('getRequestMethod')
                  ->will($this->returnValue('POST'));

      $route = new Route(array('requestMethodCollection' => $requestMethodCollectionMock));
      $route->validateRequestMethod($requestMock);
   }

   public function testGetSubRoute(){
      $subRoutesCollection = new SubRouteCollection(array('login' => array()));
      $route               = new Route(array('subRoutesCollection' => $subRoutesCollection));

      $requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                          ->disableOriginalConstructor()
                          ->getMock();

      $requestMock->expects($this->once())
                  ->method('getAction')
                  ->will($this->returnValue('login'));

      $result = $route->getSubRoute($requestMock);
      $this->assertTrue($result instanceof Route);
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\NoSuchRouteException
    * @expectedExceptionMessage Ogiltig url.
    */
   public function testGetNonExistingSubRoute(){
      $subRoutesCollection = new SubRouteCollection(array('login' => array()));
      $route               = new Route(array('subRoutesCollection' => $subRoutesCollection));

      $requestMock = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                          ->disableOriginalConstructor()
                          ->getMock();

      $requestMock->expects($this->once())
                  ->method('getAction')
                  ->will($this->returnValue('noway'));

      $result = $route->getSubRoute($requestMock);
      $this->assertTrue($result instanceof Route);
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\UserIsNotAllowedException
    * @expectedExceptionMessage Du saknar behörighet för denna resurs.
    */
   public function testIsUserAllowedInvalid(){

      $accessRule = new AdministrativeAccessRule();

      $route = new Route(array('accessRule' => $accessRule));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('hasAdministrativeAccess')
               ->will($this->returnValue(false));

      $route->isUserAllowed($userMock);
   }

   public function testIsUserAllowed(){

      $accessRule = new AdministrativeAccessRule();

      $route = new Route(array('accessRule' => $accessRule));

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('hasAdministrativeAccess')
               ->will($this->returnValue(true));

      $this->assertTrue($route->isUserAllowed($userMock));
   }
} 