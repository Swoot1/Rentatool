<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 17:29
 */

namespace Application\PHPFramework\Response;

use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\Interfaces\IToArray;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Response\Models\Notifier;

class NoName extends GeneralModel{
   protected $metadata;
   protected $responseData;
   /**
    * @var ContentTypeConverter
    */
   private $_contentTypeConverter;

   /**
    * @param ContentTypeConverter $contentTypeConverter
    * @param Metadata $metadata
    */
   public function __construct(ContentTypeConverter $contentTypeConverter, Metadata $metadata){
      $this->_contentTypeConverter = $contentTypeConverter;
      $this->metadata              = $metadata;

      return $this;
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }

   /**
    * Returns the data as a string formatted in the correct contentType.
    * @param $contentType
    * @return string
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   public function getFormattedData($contentType){

      if ($contentType === 'application/json'){
         $formattedData = $this->_contentTypeConverter->convertDataToJSON($this->toArray());
      } else if ($contentType === 'text/html'){
         $formattedData = $this->toArray()['responseData'];
      } else{
         throw new ApplicationException('Ange en giltig content-type.');
      }

      return $formattedData;
   }

   public function setResponseData(IToArray $data){
      $this->responseData = $data;

      return $this;
   }

   public function addNotifier(Notifier $notifier){
      $this->metadata->addNotifier($notifier);

      return $this;
   }
} 