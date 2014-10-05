<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 18:41
 * To change this template use File | Settings | File Templates.
 */

use Application\Models\MenuItem;
use Application\PHPFramework\Response\Metadata;
use Application\PHPFramework\Response\Models\Notifier;
use Application\PHPFramework\Response\NotificationCollection;
use Application\PHPFramework\Response\ResponseData;

class ResponseDataTest extends PHPUnit_Framework_TestCase{

   /**
    * @var ResponseData
    */
   private $responseData;

   public function setUp(){
      $notificationCollection = new NotificationCollection();
      $metadata               = new Metadata($notificationCollection);
      $this->responseData     = new ResponseData($metadata);
   }

   public function testGetFormattedJSONData(){
      $this->responseData->setResponseData(new MenuItem());

      $formattedData = $this->responseData->getFormattedData('application/json');
      $parsedData    = json_decode($formattedData, true);

      $this->assertArrayHasKey('metadata', $parsedData);
      $this->assertArrayHasKey('data', $parsedData);
   }

   public function testGetFormattedTextData(){
      $this->responseData->setResponseData(new MenuItem());
      $formattedData = $this->responseData->getFormattedData('text/html');

      $this->assertInternalType('array', $formattedData);
   }

   public function testAddNotifier(){
      $this->responseData->addNotifier(new Notifier(['message' => 'My notifier']));
      $formattedData = $this->responseData->getFormattedData('application/json');
      $parsedData    = json_decode($formattedData, true);

      $this->assertEquals('My notifier', $parsedData['metadata']['notificationCollection'][0]['message']);
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange en giltig content-type.
    */
   public function testInvalidContentType(){
      $this->responseData->getFormattedData('content/type');
   }

}