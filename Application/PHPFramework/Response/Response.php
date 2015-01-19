<?php
/**
 * User: Elin
 * Date: 2014-07-07
 * Time: 11:29
 */

namespace Application\PHPFramework\Response;

use Application\PHPFramework\Interfaces\IToArray;
use Application\PHPFramework\IPagination;
use Application\PHPFramework\Response\Models\Notifier;

/**
 * Class Response
 * @package Application\PHPFramework\Response
 */
class Response implements IResponse{

   private $protocol = '';
   private $statusCode = 200;
   private $contentType = 'application/json';
   private $charset = 'utf-8';
   private $responseData;
   private $statusCodeToTextMapper;
   private $headerDispatcher;

   public function __construct(StatusCodeToTextMapper $statusCodeToTextMapper, ResponseData $responseData, IHeaderDispatcher $headerDispatcher){
      $this->responseData           = $responseData;
      $this->statusCodeToTextMapper = $statusCodeToTextMapper;
      $this->headerDispatcher       = $headerDispatcher;
      $this->setProtocol();
   }

   public function setResponseData(IToArray $data){
      $this->responseData->setResponseData($data);

      return $this;
   }

   public function addNotifier(array $notifierData){
      $notifier = new Notifier($notifierData);
      $this->responseData->addNotifier($notifier);

      return $this;

   }

   public function setPaginationInfo(IPagination $pagination){
      $this->responseData->setPaginationInfo($pagination);

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

      $this->headerDispatcher->setHeader(sprintf("%s %s", $this->protocol, $statusCodeText), true, $this->statusCode);
      $this->headerDispatcher->setHeader($charset);
      $this->headerDispatcher->setHeader($contentType);

      return $this;
   }

   /**
    * @return $this
    */
   private function sendData(){
      echo $this->responseData->getFormattedData($this->contentType);

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