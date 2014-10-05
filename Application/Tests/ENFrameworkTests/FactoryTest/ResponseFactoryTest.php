<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 15:37
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\PHPFrameworkTests\FactoryTest;


use Application\PHPFramework\Response\Factories\ResponseFactory;

class ResponseFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testBuild(){
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->build();

      $this->assertInstanceOf('Application\PHPFramework\Response\Response', $response);
   }

}