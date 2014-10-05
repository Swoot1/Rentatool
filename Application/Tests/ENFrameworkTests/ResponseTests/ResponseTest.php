<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 17:16
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Tests\PHPFrameworkTests\ResponseTests;


use Application\Models\MenuItem;
use Application\PHPFramework\Response\Metadata;
use Application\PHPFramework\Response\NotificationCollection;
use Application\PHPFramework\Response\Response;
use Application\PHPFramework\Response\ResponseData;
use Application\PHPFramework\Response\StatusCodeToTextMapper;

class ResponseTest extends \PHPUnit_Framework_TestCase{

   private $statusCodeMapper;

   public function setUp(){
      $this->statusCodeMapper = new StatusCodeToTextMapper();
   }

   public function testResponseDataStructure(){
      $response = $this->createResponseObject();

      ob_start();
      $response->sendResponse();
      $rawResponse = ob_get_contents();
      ob_end_clean();

      $parsedResponse = json_decode($rawResponse, true);

      $this->assertArrayHasKey('metadata', $parsedResponse);
      $this->assertArrayHasKey('notificationCollection', $parsedResponse['metadata']);
      $this->assertArrayHasKey('data', $parsedResponse);
   }

   public function testAddNotifiers(){
      $response = $this->createResponseObject();
      $response->addNotifier(['message' => 'Testing responses']);
      $response->addNotifier(['message' => 'Testing more responses']);

      ob_start();
      $response->sendResponse();
      $rawResponse = ob_get_contents();
      ob_end_clean();

      $parsedResponse = json_decode($rawResponse, true);

      $this->assertCount(2, $parsedResponse['metadata']['notificationCollection']);
   }


   private function createResponseObject(){
      $headerDispatcher = $this->getMock('Application\PHPFramework\Response\HeaderDispatcher');
      $metadata         = new Metadata(new NotificationCollection());
      $responseData     = new ResponseData($metadata);
      $response         = new Response($this->statusCodeMapper, $responseData, $headerDispatcher);

      $response->setStatusCode(200);
      $response->setContentType('application/json');
      $response->setResponseData(new MenuItem());

      return $response;
   }

}