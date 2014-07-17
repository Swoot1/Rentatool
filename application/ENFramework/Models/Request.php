<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:50
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Models;


use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\MethodNotAllowedException;

class Request extends GeneralModel{
   /**
    * @var \Rentatool\Application\Collections\RequestMethodCollection
    */
   private $requestMethodCollection;
   private $requestMethod;
   private $urlParams;
   private $requestURI;
   private $resource;


   public function __construct(array $data, RequestMethodCollection $requestMethodCollection){
      $this->setRequestMethodCollection($requestMethodCollection);
      parent::__construct($data);
   }


   private function setRequestMethodCollection(RequestMethodCollection $requestMethodCollection){
      $this->requestMethodCollection = $requestMethodCollection;
   }


   public function setRequestURI($value){
      $this->requestURI = $value;
   }


   public function getResource(){
      return $this->resource;
   }


   public function setResource($resource) {
      $this->resource = $resource;
   }


   public function getRequestURI(){
      return $this->requestURI;
   }


   /**
    * @param $requestMethod
    * @internal param array $serverArray
    */
   public function setRequestMethod($requestMethod){
      $this->validateRequestMethod($requestMethod);
      $this->requestMethod = $requestMethod;
   }


   public function getRequestMethod(){
      return $this->requestMethod;
   }


   public function setURLParams(array $urlParams){
      $this->urlParams = $urlParams;

      return $this;
   }


   public function getURLParams(){
      return $this->urlParams;
   }


   /**
    * @param $methodName
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\MethodNotAllowedException
    * @return bool
    */
   private function validateRequestMethod($methodName){
      $isValidRequestMethod = $this->requestMethodCollection->isValidRequestMethod($methodName);

      if (!$isValidRequestMethod){
         throw new MethodNotAllowedException('Ange en vettig request-typ för bövelen.');
      }

      return true;
   }


   public function setUpValidation(){
      // TODO
   }


   public function getRequestData(){
      return json_decode(file_get_contents("php://input"), true);
   }
}