<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 17:57
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Response;


/**
 * Proxy class for php native header()-method.
 * Used to make classes using header() testable.
 *
 * Class HeaderDispatcher
 * @package Application\PHPFramework\Response
 */
class HeaderDispatcher implements IHeaderDispatcher {

   /**
    * @param $string
    * @param null $replace
    * @param null $statusCode
    */
   public function setHeader($string, $replace = null, $statusCode = null) {
      header($string, $replace, $statusCode);
   }

}