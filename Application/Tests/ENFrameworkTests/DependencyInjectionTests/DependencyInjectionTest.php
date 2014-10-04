<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/08/14
 * Time: 16:16
 */

namespace Tests\ENFrameworkTests\DependencyInjectionTests;


use Application\ENFramework\DependencyInjection\DependencyInjection;

class DependencyInjectionTest extends \PHPUnit_Framework_TestCase{

   public function testGetController(){
      $dependencyInjectionContainer = simplexml_load_file('/Application/ENFramework/DependencyInjection/DependencyInjectionContainer.xml');
      $requestMock                  = $this->getMockBuilder('/Application/Request')
                                           ->disableOriginalConstructor()
                                           ->getMock();
      $dependencyInjection          = new DependencyInjection($dependencyInjectionContainer, $requestMock);
      $userController               = $dependencyInjection->getInstantiatedClass('UserController');
      $expectedUserControllerMock   = $this->getMockBuilder('/Application/Controllers/UserController')
                                           ->disableOriginalConstructor()
                                           ->getMock();
      $this->assertTrue($userController instanceof $expectedUserControllerMock);
   }

} 
