<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-13
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 */

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookieJar\FileCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;

class AuthorizationTest extends PHPUnit_Framework_TestCase{

   /** @var Client */
   private $client;

   // TODO: Set globals in phpunit.xml for valid user/psw/url

   public function setUp(){
      $this->client = new Client('http://localhost/rentatool/', ['request.options' => ['exceptions' => false]]);
      $cookiePlugin = new CookiePlugin(new FileCookieJar('guzzleCookies'));
      $this->client->addSubscriber($cookiePlugin);
   }

   public function testNonExistingLogin(){
      $requestBody = json_encode(['email' => 'herp@derp.se', 'password' => 'derp']);
      $request     = $this->client->post('authorization/login', [], $requestBody);
      $response    = $request->send();

      $this->assertEquals(404, $response->getStatusCode());
   }

   public function testIncorrectPassword(){
      $requestBody = json_encode(['email' => 'andy@andy.se', 'password' => 'derp']);
      $request     = $this->client->post('authorization/login', [], $requestBody);
      $response    = $request->send();

      $this->assertEquals(403, $response->getStatusCode());
   }

   public function testValidLogin(){
      $requestBody  = json_encode(['email' => 'andy@andy.se', 'password' => 'andy']);
      $request      = $this->client->post('authorization/login', [], $requestBody);
      $response     = $request->send();
      $responseData = $response->json();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertTrue($responseData['data']['isLoggedIn']);
   }

   public function testLogout(){
      $requestBody = json_encode(['email' => 'andy@andy.se', 'password' => 'andy']);
      $request     = $this->client->post('authorization/login', [], $requestBody);
      $request->send();

      $request = $this->client->get('authorization/logout');
      $request->send();

      $request  = $this->client->get('users');
      $response = $request->send();

      $this->assertEquals(403, $response->getStatusCode());
   }

}