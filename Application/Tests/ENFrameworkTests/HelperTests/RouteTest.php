<?php
/**
 * User: Elin
 * Date: 2014-07-04
 * Time: 09:09
 */

namespace Tests\ENFrameworkTests\HelperTests;

use Application\ENFramework\Helpers\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testGetController()
    {
        $route = new Route(
            array(
                'resource' => 'users',
                'controllerName' => 'UserController'
            )
        );

        $this->assertEquals('UserController', $route->getController());
    }

    /**
     * Test that isMatchingRoute works with the simplest of test cases.
     */
    public function testIsMatchingRouteFish()
    {
//        $route = new Route(array(
//            'resource' => 'fish',
//            'controllerName' => 'FishController'
//        ));
//
//        $isMatchingRoute = $route->isMatchingRoute('fish');
//
//        $this->assertTrue($isMatchingRoute);

    }

    /**
     * Test that isMatchingRoute works with get params.
     */
    public function testIsMatchingRouteWithGetParams()
    {
//        $userRoute = new Route(array(
//            'resource' => 'user',
//            'controllerName' => 'userController'
//        ));
//
//        $isMatchingRoute = $userRoute->isMatchingRoute('user?test=1&testmore=false');
//
//        $this->assertTrue($isMatchingRoute);

    }

    /**
     * Test that a route that doesn't match the route model returns false when calling
     * isMatchingRoute.
     */
    public function testIsNotMatchingRoute()
    {
//        $fishRoute = new Route(array(
//            'resource' => 'fish',
//            'controllerName' => 'FishController'
//        ));
//
//        $isMatchingRoute = $fishRoute->isMatchingRoute('fishparty/123');
//
//        $this->assertFalse($isMatchingRoute);

    }
} 