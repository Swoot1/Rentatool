<?php
/**
 * User: Elin
 * Date: 2014-07-30
 * Time: 17:34
 */

namespace Application\ENFramework\Routing;


use Application\ENFramework\ErrorHandling\Exceptions\NoSuchRouteException;
use Application\ENFramework\Request\Request;

class SubRouteCollection{

   private $routes = [];


   public function __construct(array $routes = array()){
      foreach ($routes as $path => $route){
         $this->addRoute($path, $route);
      }
   }

   /**
    * Returns the route that corresponds with the request options.
    * @param Request $request
    * @return mixed
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\NoSuchRouteException
    */
   public function getSubRouteFromRequest(Request $request){
      $resource = $request->getAction();
      if (!array_key_exists($resource, $this->routes)){
         throw new NoSuchRouteException('Ogiltig url');
      }

      $route = $this->routes[$resource];

      return $route;
   }


   private function addRoute($path, array $route){
      $this->routes[$path] = new Route($route);
   }
} 