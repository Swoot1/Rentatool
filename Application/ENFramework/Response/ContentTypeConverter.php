<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:17
 */

namespace Application\ENFramework\Response;


class ContentTypeConverter{
   /**
    * Returns the data array as json.
    * @param $data
    * @return string
    */
   public function convertDataToJSON($data){
      return json_encode($data, JSON_UNESCAPED_UNICODE); // TODO remove
   }
} 