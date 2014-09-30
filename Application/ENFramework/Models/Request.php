<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:50
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Models;


use Application\Collections\RequestMethodCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\MethodNotAllowedException;
use Rentatool\Application\ENFramework\Helpers\JsonParser;

class Request extends GeneralModel{
   /**
    * @var \Application\Collections\RequestMethodCollection
    */
   private $requestMethodCollection;
   private $requestMethod;
   private $requestURI;
   private $resource;
   private $contentType;
   private $id = false;
   private $action = false;


   public function __construct(array $data, RequestMethodCollection $requestMethodCollection){
      $this->setRequestMethodCollection($requestMethodCollection);
      parent::__construct($data);
   }


   private function setRequestMethodCollection(RequestMethodCollection $requestMethodCollection){
      $this->requestMethodCollection = $requestMethodCollection;
   }


   public function setRequestURI($value){
      $this->requestURI = $value;
      $this->setURLSubParts();
   }

   /**
    * Extracts resource and id/action from the URI.
    * @return $this
    */
   private function setURLSubParts(){
      preg_match('/(\w+)(?:\/(\d+|\w+))?/', $this->requestURI, $matches);

      if (count($matches) > 0){
         $this->resource = array_key_exists(1, $matches) ? $matches[1] : false;

         if (array_key_exists(2, $matches)){

            if (is_numeric($matches[2])){
               $this->id = (int)$matches[2];
            } else{
               $this->action = $matches[2];
            }
         }
      }

      return $this;
   }


   public function getResource(){
      return $this->resource;
   }

   public function setResource($resource){
      $this->resource = $resource;
   }

   public function getId(){
      return $this->id;
   }

   public function getAction(){
      return $this->action;
   }

   /**
    * @param $requestMethod
    * @internal param array $serverArray
    */
   public function setRequestMethod($requestMethod){
      $this->validateRequestMethod($requestMethod);
      $this->requestMethod = $requestMethod;
   }

   public function setContentType($contentType){
      $this->contentType = $contentType;
   }


   public function getRequestMethod(){
      return $this->requestMethod;
   }

   /**
    * @param $methodName
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\MethodNotAllowedException
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

      $files = preg_match('/multipart\/form-data;/', $this->contentType);

      if ($files){
         $filesCopy = $_FILES;
         $result = array_shift($filesCopy);
      } else{
         $jsonParser = new JsonParser();
         $result = $jsonParser->parse(file_get_contents('php://input'));
      }

      return $result;
   }

   public function getGETParameters(){
      return $_GET;
   }
}