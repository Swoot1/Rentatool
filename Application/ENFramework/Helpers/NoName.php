<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 17:29
 */

namespace Application\ENFramework\Helpers;

use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\ENFramework\Helpers\Interfaces\IToArray;
use Application\ENFramework\Models\GeneralModel;

class NoName extends GeneralModel{
   /**
    * @var \Application\ENFramework\Helpers\Metadata
    */
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
    * @throws ErrorHandling\Exceptions\ApplicationException
    */
   public function getFormattedData($contentType){

      if ($contentType === 'application/json'){
         $formattedData = $this->_contentTypeConverter->convertDataToJSON($this->toArray());
      }else if($contentType === 'text/html'){
         $formattedData = $this->toArray()['responseData'];
      }
      else{
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