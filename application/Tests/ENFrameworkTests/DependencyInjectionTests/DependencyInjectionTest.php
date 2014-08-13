<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/08/14
 * Time: 16:16
 */

namespace Rentatool\Tests\ENFrameworkTests\DependencyInjectionTests;


use Rentatool\Application\ENFramework\Helpers\DependencyInjection\DependencyInjection;

class DependencyInjectionTest extends \PHPUnit_Framework_TestCase{

   public function testGetController(){
      $dependencyInjectionContainer = simplexml_load_file('Application/ENFramework/Helpers/DependencyInjection/DependencyInjectionContainer.xml');
      $dependencyInjection = new DependencyInjection($dependencyInjectionContainer);
      $userController = $dependencyInjection->getInstantiatedClass('UserController');
      $expectedUserControllerMock = $this->getMockBuilder('/Application/Controllers/UserController')
         ->disableOriginalConstructor()
         ->getMock();
      $this->assertTrue($userController instanceof $expectedUserControllerMock);
   }

} 