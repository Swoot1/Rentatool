<?php
/**
 * User: Elin
 * Date: 2014-07-07
 * Time: 11:29
 */

namespace Rentatool\Application\ENFramework\Helpers;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

/**
 * Class Header
 * Creates and can execute a header() based on its data.
 * @package Rentatool\Application\ENFramework\Helpers
 */
class Response implements IResponse {

   private $protocol;
   private $statusCode = 200;
   private $contentType = 'application/json';
   private $charset = 'utf-8';
   private $data;
   private $contentTypeConverter;
   private $statusCodeToTextMapper;

   public function __construct(ContentTypeConverter $contentTypeConverter, StatusCodeToTextMapper $statusCodeToTextMapper) {
      $this->contentTypeConverter   = $contentTypeConverter;
      $this->statusCodeToTextMapper = $statusCodeToTextMapper;
      $this->setProtocol();
   }

   private function setProtocol() {
      $this->protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';

      return $this;
   }

   public function setStatusCode($code) {
      $this->statusCode = $code;

      return $this;
   }

   public function setData($data) {
      $this->data = $data;

      return $this;
   }

   public function setContentType($contentType) {
      $this->contentType = $contentType;

      return $this;
   }

   /**
    * Returns a response to the user based on the objects data.
    * @return $this
    */
   public function sendResponse() {
      $this->sendHeaders();
      $this->sendData();

      return $this;
   }

   /**
    * Sends the appropriate headers based on the objects data.
    * @return $this
    */
   private function sendHeaders() {
      $statusCodeText = $this->getResponseCodeString();
      $charset        = $this->getCharsetString();
      $contentType    = $this->getContentTypeString();

      header(sprintf("%s %s", $this->protocol, $statusCodeText), true, $this->statusCode);
      header($charset);
      header($contentType);

      return $this;
   }

   private function sendData() {
      echo $this->getFormattedData();

      return $this;
   }

   private function getContentTypeString() {
      return $this->contentType ? sprintf('Content-Type: %s', $this->contentType) : '';
   }

   private function getResponseCodeString() {
      $statusCodeText = $this->statusCodeToTextMapper->getResponseCodeText($this->statusCode);

      return $this->statusCode ? sprintf('%s %s', $this->statusCode, $statusCodeText) : '';
   }

   private function getCharsetString() {
      return $this->charset ? sprintf('Charset:%s', $this->charset) : '';
   }

   /**
    * Returns the data as a string formatted in the correct contentType.
    * @return string
    * @throws ErrorHandling\Exceptions\ApplicationException
    * @throws \Exception
    */
   private function getFormattedData() {
      $contentType = mb_strtolower($this->contentType);

      switch ($contentType) {
         case 'application/json':
            $formattedData = $this->contentTypeConverter->convertDataToJSON($this->data);
            break;
         case 'application/xml':
            $formattedData = $this->contentTypeConverter->convertDataToXML($this->data);
            break;
         default:
            throw new ApplicationException('Ange en giltig content-type.');
            break;
      }

      return $formattedData;
   }
} 