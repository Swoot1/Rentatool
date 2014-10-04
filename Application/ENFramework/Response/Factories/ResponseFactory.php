<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:21
 */

namespace Application\ENFramework\Response\Factories;

use Application\ENFramework\Response\ContentTypeConverter;
use Application\ENFramework\Response\Metadata;
use Application\ENFramework\Response\NoName;
use Application\ENFramework\Response\NotificationCollection;
use Application\ENFramework\Response\Response;
use Application\ENFramework\Response\StatusCodeToTextMapper;

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