<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 19:19
 * To change this template use File | Settings | File Templates.
 */

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookieJar\FileCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;

class ExampleGuzzleTest extends PHPUnit_Framework_TestCase{

   public function testExample(){
      $client = new Client('http://localhost/');

      $request      = $client->get('rentatool/menuitems');
      $response     = $request->send();
      $responseData = $response->json();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertArrayHasKey('metadata', $responseData);
      $this->assertArrayHasKey('data', $responseData);
   }


   public function testSession() {
      $client       = new Client('http://localhost/');

      // Needed to make sessions work. Find a better place to put the cookie file.
      $cookiePlugin = new CookiePlugin(new FileCookieJar('guzzleCookies'));
      $client->addSubscriber($cookiePlugin);

      $requestBody  = json_encode(['email' => 'andy@andy.se', 'password' => 'andy']);
      $request      = $client->post('rentatool/authorization/login', [], $requestBody);
      $response     = $request->send();
      $responseData = $response->json();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertTrue($responseData['data']['isLoggedIn']);

      // New request with same session. Get menu to see if we are logged in. Find better way.
      $request      = $client->get('rentatool/menuitems');
      $response     = $request->send();
      $responseData = $response->json();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertCount(3, $responseData['data']);
   }

}