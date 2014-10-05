<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 19:19
 * To change this template use File | Settings | File Templates.
 */

use Guzzle\Http\Client;

class ExampleGuzzleTest extends PHPUnit_Framework_TestCase{

   public function testExample(){
//      $client = new Client('http://localhost/rentatool'); // Skips "rentatool" for some reason
      $client = new Client('http://localhost/');

      $request      = $client->get('rentatool/menuitems');
      $response     = $request->send();
      $responseData = $response->json();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertArrayHasKey('metadata', $responseData);
      $this->assertArrayHasKey('data', $responseData);
   }

}