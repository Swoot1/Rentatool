<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:21
 */

namespace Rentatool\Application\ENFramework\Helpers;


class ResponseFactory {

   public function createResponse() {
      $contentTypeConverter   = new ContentTypeConverter();
      $statusCodeToTextMapper = new StatusCodeToTextMapper();

      return new Response($contentTypeConverter, $statusCodeToTextMapper);
   }
} 