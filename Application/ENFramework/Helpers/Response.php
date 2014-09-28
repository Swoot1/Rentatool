<?php
/**
 * User: Elin
 * Date: 2014-07-07
 * Time: 11:29
 */

namespace Application\ENFramework\Helpers;

use Application\ENFramework\Helpers\Interfaces\IToArray;


/**
 * Class Header
 * Creates and can execute a header() based on its data.
 * @package Application\ENFramework\Helpers
 */
class Response implements IResponse{

   private $protocol = '';
   private $statusCode = 200;
   private $contentType = 'application/json';
   private $charset = 'utf-8';
   /**
    * @var \Application\ENFramework\Helpers\MetaData
    */
   private $noName;
   private $statusCodeToTextMapper;

   public function __construct(StatusCodeToTextMapper $statusCodeToTextMapper, NoName $noName){
      $this->noName                 = $noName;
      $this->statusCodeToTextMapper = $statusCodeToTextMapper;
      $this->setProtocol();
   }

   public function setResponseData(IToArray $data){
      $this->noName->setResponseData($data);

      return $this;
   }

   public function addNotifier(array $notifierData){
      $notifier = new Notifier($notifierData);
      $this->noName->addNotifier($notifier);

      return $this;

   }

   public function setContentType($value){
      $this->contentType = $value;
      return $this;
   }

   private function setProtocol(){
      $this->protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';

      return $this;
   }

   public function setStatusCode($code){
      $this->statusCode = $code;

      return $this;
   }

   /**
    * Returns a response to the user based on the objects data.
    * @return $this
    */
   public function sendResponse(){
      $this->sendHeaders();
      $this->sendData();

      return $this;
   }

   /**
    * Sends the appropriate headers based on the objects data.
    * @return $this
    */
   private function sendHeaders(){
      $statusCodeText = $this->getResponseCodeString();
      $charset        = $this->getCharsetString();
      $contentType    = $this->getContentTypeString();

      header(sprintf("%s %s", $this->protocol, $statusCodeText), true, $this->statusCode);
      header($charset);
      header($contentType);

      return $this;
   }

   /**
    * @return $this
    */
   private function sendData(){
      echo $this->noName->getFormattedData($this->contentType);

      return $this;
   }

   private function getContentTypeString(){
      return $this->contentType ? sprintf('Content-Type: %s', $this->contentType) : '';
   }

   private function getResponseCodeString(){
      $statusCodeText = $this->statusCodeToTextMapper->getResponseCodeText($this->statusCode);

      return $this->statusCode ? sprintf('%s %s', $this->statusCode, $statusCodeText) : '';
   }

   private function getCharsetString(){
      return $this->charset ? sprintf('Charset:%s', $this->charset) : '';
   }

} 