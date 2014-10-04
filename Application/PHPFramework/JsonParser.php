<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-12
 * Time: 23:01
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework;


use Application\PHPFramework\ErrorHandling\Exceptions\BadJsonException;

class JsonParser{

   public function parse($json){
      $parsedData = json_decode($json, true);
      $jsonError  = json_last_error();

      if ($jsonError !== JSON_ERROR_NONE){
         switch ($jsonError){
            case JSON_ERROR_CTRL_CHAR:
            case JSON_ERROR_UTF8:
               $errorText = 'Ogiltig encoding';
               break;
            default:
               $errorText = 'Ogiltigt format';
         }

         throw new BadJsonException(sprintf('Ogiltig JSON: %s', $errorText));
      }

      return $parsedData ? $parsedData : [];
   }

}
