<?php
/**
 * User: Elin
 * Date: 2014-06-21
 * Time: 11:19
 */

namespace Rentatool\Application\ENFramework\Helpers\Routing;


use Rentatool\Application\ENFramework\Helpers\DependencyInjection\DependencyInjection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException;
use Rentatool\Application\ENFramework\Models\Request;

class Routing {

   private $request;
   private $dependencyInjector;

   public function __construct(Request $request, \SimpleXMLElement $dependencyInjector) {
      $this->request            = $request;
      $this->dependencyInjector = $dependencyInjector;
   }

   /**
    * @param $id
    * @param Request $request
    * @return mixed
    * @throws ApplicationException
    */
   public function callMethod(Route $route) {
      $controller    = $this->getController($route);
      $requestMethod = $this->request->getRequestMethod();

      switch ($requestMethod) {
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
    * @param String $controllerName
    * @return null|object
    */
   private function getController(Route $route) {
      $dependencyInjectionContainer = new DependencyInjection($this->dependencyInjector);

      return $dependencyInjectionContainer->getInstantiatedClass($route->getController());
   }

   /**
    * @param $controller
    * @return mixed
    */
   private function callGetMethod($controller) {
      $id          = $this->request->getId();
      $action      = $this->request->getAction();
      $requestData = $this->request->getRequestData();

      if ($id || $action) {

         if ($id) {
            $result = $controller->read($id);
         } else {
            $result = call_user_func(array($controller, $action), $requestData);
         }

      } else {
         $result = $controller->index();
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function callDeleteMethod($controller) {
      $id = $this->request->getId();

      if ($id) {
         $result = $controller->delete($id);
      } else {
         throw new ApplicationException('Ange ett id för borttagning.');
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    */
   private function callPostMethod($controller) {
      $action      = $this->request->getAction();
      $requestData = $this->request->getRequestData();

      if ($action) {
         $result = call_user_func(array($controller, $action), $requestData);
      } else {
         $result = $controller->create($requestData);
      }

      return $result;
   }

   /**
    * @param $controller
    * @return mixed
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function callPutMethod($controller) {
      $id          = $this->request->getId();
      $requestData = $this->request->getRequestData();

      if ($id) {
         $result = $controller->update($id, $requestData);
      } else {
         throw new ApplicationException('Ange ett id för uppdatering.');
      }

      return $result;
   }
} 