<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:21
 */

namespace Application\ENFramework\Helpers;


use Application\ENFramework\Collections\NotificationCollection;

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