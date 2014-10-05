<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 18:02
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Response;


interface IHeaderDispatcher{

   public function setHeader($string, $replace = null, $statusCode = null);

}