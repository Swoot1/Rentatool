<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 20:59
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers;

class RequestDispatcher{
   private $requestModel;

   public function __construct(){
      $requestFactory     = new RequestFactory($_SERVER);
      $this->requestModel = $requestFactory->build();
   }

   public function getRequestModel(){
      return $this->requestModel;
   }
}