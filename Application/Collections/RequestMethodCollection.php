<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 17:10
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Collections;


class RequestMethodCollection {

   private $data;

   public function __construct(array $allowedMethods) {
      $this->data = $allowedMethods;
   }

   /**
    * @param $methodName
    * @return bool
    */
   public function isValidRequestMethod($methodName) {
      return array_search($methodName, $this->data) !== false;
   }
}