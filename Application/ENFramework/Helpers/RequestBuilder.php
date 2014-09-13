<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 21:23
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers;


use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Models\Request;

class RequestBuilder{
   private $buildSource;
   /**
    * @var \Rentatool\Application\ENFramework\Models\Request
    */
   private $requestModel;


   /**
    * @param array $buildSource
    * @param RequestMethodCollection $requestMethodCollection
    * @internal param $_SERVER |array $buildSource
    */
   public function __construct(array $buildSource, RequestMethodCollection $requestMethodCollection){
      $this->requestModel = new Request(array(), $requestMethodCollection);
      $this->buildSource  = $buildSource;
   }


   /**
    * @return mixed
    */
   public function build(){
      $this->setURI();
      $this->setRequestMethod();
      $this->setContentType();

      return $this->requestModel;
   }


   /**
    * Sets if the request method is PUT/POST/etc.
    * @return $this
    */
   private function setRequestMethod(){
      $requestMethod = $this->buildSource['REQUEST_METHOD'];
      $this->requestModel->setRequestMethod($requestMethod);

      return $this;
   }

   private function setContentType(){
      $contentType = isset($this->buildSource['CONTENT_TYPE']) ? $this->buildSource['CONTENT_TYPE'] : null;
      $this->requestModel->setContentType($contentType);

      return $this;
   }


   private function setURI(){
      $this->requestModel->setRequestURI(ltrim($this->buildSource['REQUEST_URI'], '/'));

      return $this;
   }
}