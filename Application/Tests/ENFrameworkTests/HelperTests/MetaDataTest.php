<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 11:11
 */

namespace Tests\ENFrameworkTests\HelperTests;


use Application\ENFramework\Collections\NotificationCollection;
use Application\ENFramework\Helpers\ContentTypeConverter;
use Application\ENFramework\Helpers\Metadata;
use Application\ENFramework\Helpers\Notifier;

class MetaDataTest extends \PHPUnit_Framework_TestCase{

   /**
    * The simplest test to make sure that the metadata is returned as a string object and not an array.
    */
   public function testGetFormattedData(){
      $contentTypeConverter = new ContentTypeConverter();
      $metadata             = new Metadata($contentTypeConverter);
      $metadataString       = $metadata->getFormattedData('application/json');

      $this->assertEquals('{"responseData":null,"notificationCollection":[]}', $metadataString);
   }

   /**
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange en giltig content-type.
    */
   public function testInvalidContentType(){
      $contentTypeConverter = new ContentTypeConverter();
      $metadata             = new Metadata($contentTypeConverter);
      $metadata->getFormattedData('application/xml');
   }

   public function testNotifiers(){
      $contentTypeConverter = new ContentTypeConverter();
      $metadata             = new Metadata($contentTypeConverter);
      $notification         = new Notifier(
         array('type'    => Notifier::SECONDARY,
               'message' => 'Funkar.'));
      $metadata->addNotifier($notification);
      $metadataString = $metadata->getFormattedData('application/json');

      $this->assertEquals('{"responseData":null,"notificationCollection":[{"message":"Funkar.","type":"secondary"}]}',
                          $metadataString);
   }

   public function testResponseData(){
      $contentTypeConverter = new ContentTypeConverter();
      $metadata             = new Metadata($contentTypeConverter, new NotificationCollection());
      $userMock             = $this->getMock('\Application\Models\User');
      $userMock->expects($this->any())->method('toArray')->will($this->returnValue(array('id'       => 1,
                                                                                         'username' => 'Elin')));
      $metadata->setResponseData($userMock);
      $metadataString = $metadata->getFormattedData('application/json');

      $this->assertEquals('{"responseData":{"id":1,"username":"Elin"},"notificationCollection":[]}',
                          $metadataString);
   }
} 