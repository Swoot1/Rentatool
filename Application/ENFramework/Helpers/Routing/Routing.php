<?php
/**
 * User: Elin
 * Date: 2014-06-21
 * Time: 11:19
 */

namespace Application\ENFramework\Helpers\Routing;

use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException;
use Application\ENFramework\Models\Request;

class Routing{

   private $request;

   public function __construct(Request $request){
      $this->request = $request;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException
    */
   public function callMethod($controller){
      $requestMethod = $this->request->getRequestMethod();

      switch ($requestMethod){
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
      $id          = $this->request->getId();
      $action      = $this->request->getAction();
      $requestData = $this->request->getRequestData();

      if ($id || $action){

         if ($id){
            $result = $controller->read($id);
         } else{
            $result = call_user_func(array($controller, $action), $requestData);
         }

      } else{
         $result = $controller->index();
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function callDeleteMethod($controller){
      $id = $this->request->getId();

      if ($id){
         $result = $controller->delete($id);
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
      $action      = $this->request->getAction();
      $requestData = $this->request->getRequestData();

      if ($action){
         $result = call_user_func(array($controller, $action), $requestData);
      } else{
         $result = $controller->create($requestData);
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function callPutMethod($controller){
      $id = $this->request->getId();

      if ($id){
         $requestData       = $this->request->getRequestData();
         $requestData['id'] = $id;
         $result            = $controller->update($id, $requestData);
      } else{
         throw new ApplicationException('Ange ett id för uppdatering.');
      }

      return $result;
   }
} 