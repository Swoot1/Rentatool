<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 21:23
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers;

use Application\ENFramework\Models\Request;
use Rentatool\Application\ENFramework\Helpers\JsonParser;

class RequestBuilder{
   private $buildSource;

   /**
    * @param array $buildSource
    * @internal param $_SERVER |array $buildSource
    */
   public function __construct(array $buildSource){
      $this->buildSource             = $buildSource;
   }


   /**
    * @return Request
    */
   public function build(){
      $data                  = array();
      $data['requestURI']    = $this->getURI();
      $data['requestMethod'] = $this->getRequestMethod();
      $data['contentType']   = $this->getContentType();
      $data['requestData']   = $this->getRequestData($data['contentType']);
      $data = array_merge($this->getURLSubParts($data['requestURI']), $data);

      return new Request($data);
   }

   private function getRequestMethod(){
      return $this->buildSource['REQUEST_METHOD'];
   }


   private function getContentType(){
      return isset($this->buildSource['CONTENT_TYPE']) ? $this->buildSource['CONTENT_TYPE'] : null;
   }


   private function getURI(){
      return ltrim($this->buildSource['REQUEST_URI'], '/');
   }


   /**
    * Extracts resource and id/action from the URI.
    * @param $requestURI
    * @return array
    */
   private function getURLSubParts($requestURI){
      preg_match('/(\w+)(?:\/(\d+|\w+))?/', $requestURI, $matches);
      $data = array();

      if (count($matches) > 0){
         $data['resource'] = array_key_exists(1, $matches) ? $matches[1] : false;

         if (array_key_exists(2, $matches)){

            if (is_numeric($matches[2])){
               $data['id'] = (int)$matches[2];
            } else{
               $data['action'] = $matches[2];
            }
         }
      }

      return $data;
   }

   public function getRequestData($contentType){

      $files = preg_match('/multipart\/form-data;/', $contentType);

      if ($files){
         $filesCopy = $_FILES;
         $result    = array_shift($filesCopy);
      } else{
         $jsonParser = new JsonParser();
         $result     = $jsonParser->parse(file_get_contents('php://input'));
      }

      return $result;
   }
}