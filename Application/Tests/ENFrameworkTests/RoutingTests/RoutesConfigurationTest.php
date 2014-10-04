<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/10/14
 * Time: 17:42
 */

namespace Tests\PHPFrameworkTests\HelperTests\Routing;


use Application\PHPFramework\Routing\RouteCollection;

class RoutesConfigurationTest extends \PHPUnit_Framework_TestCase{
   public function testLoadFile(){
      $routeCollection = include_once 'Application/PHPFramework/Routing/RoutesConfiguration.php';

      $this->assertTrue($routeCollection instanceof RouteCollection);
   }
} 