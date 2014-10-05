<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 16:50
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Request;

use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\NoSuchRouteException;
use Application\PHPFramework\Models\GeneralModel;

class Request extends GeneralModel{
   protected $requestMethod;
   protected $requestData;
   protected $resource;
   protected $contentType;
   protected $id = false;
   protected $action = false;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(array()); // TODO
   }

   public function getRequestMethod(){
      return $this->requestMethod;
   }

   public function getResource(){
      return $this->resource;
   }

   public function getId(){
      return $this->id;
   }

   public function getAction(){
      return $this->action;
   }

   public function getGETParameters(){
      return $_GET;
   }

   public function callControllerMethod($controller){

      switch ($this->requestMethod){
         case 'GET':
            $result = $this->callGetMethod($controller);
            break;
         case 'DELETE':
            $result = $this->callDeleteMethod($controller);
            break;
         case 'POST':
            $result = $this->callPostMethod($controller);
            break;
         case 'PUT':
            $result = $this->callPutMethod($controller);
            break;
         default:
            throw new NoSuchRouteException('Ogiltigt request.');
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    */
   private function callGetMethod($controller){

      if ($this->id || $this->action){

         if ($this->id){
            $result = $controller->read($this->id);
         } else{
            $result = call_user_func(array($controller, $this->action), $this->requestData);
         }

      } else{
         $result = $controller->index();
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function callDeleteMethod($controller){

      if ($this->id){
         $result = $controller->delete($this->id);
      } else{
         throw new ApplicationException('Ange ett id för borttagning.');
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    */
   private function callPostMethod($controller){

      if ($this->action){
         $result = call_user_func(array($controller, $this->action), $this->requestData);
      } else{
         $result = $controller->create($this->requestData);
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function callPutMethod($controller){

      if ($this->id){
         $requestData       = $this->requestData;
         $requestData['id'] = $this->id;
         $result            = $controller->update($this->id, $requestData);
      } else{
         throw new ApplicationException('Ange ett id för uppdatering.');
      }

      return $result;
   }
}