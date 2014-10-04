<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:21
 */

namespace Application\PHPFramework\Response\Factories;

use Application\PHPFramework\Response\ContentTypeConverter;
use Application\PHPFramework\Response\Metadata;
use Application\PHPFramework\Response\NoName;
use Application\PHPFramework\Response\NotificationCollection;
use Application\PHPFramework\Response\Response;
use Application\PHPFramework\Response\StatusCodeToTextMapper;

class ResponseFactory{

   public function createResponse(){
      $contentTypeConverter   = new ContentTypeConverter();
      $notificationCollection = new NotificationCollection();
      $metadata = new Metadata($notificationCollection);
      $noName = new NoName($contentTypeConverter, $metadata);
      $statusCodeToTextMapper = new StatusCodeToTextMapper();

      return new Response($statusCodeToTextMapper, $noName);
   }
} 