<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Routing;

use Application\ENFramework\ErrorHandling\Exceptions\NoSuchRouteException;
use Application\ENFramework\Models\Request;

class RouteCollection{

   private $routes = [];


   public function __construct(array $routes){
      foreach ($routes as $path => $route){
         $this->addRoute($path, $route);
      }
   }

   /**
    * Returns the route object that corresponds with the request options.
    * @param Request $request
    * @return mixed
    * @throws \Application\ENFramework\ErrorHandling\Exceptions\NoSuchRouteException
    */
   public function getRouteFromRequest(Request $request){
      $resource = $request->getResource();
      $resource = $resource === null ? 'index' : $resource;

      if (array_key_exists($resource, $this->routes)){
         $route = $this->routes[$resource];

         $route = $request->getAction() ? $route->getSubRoute($request) : $route;
         $route->validateRequestMethod($request);
      } else{
         throw new NoSuchRouteException('Ogiltig url.');
      }

      return $route;
   }

   private function addRoute($path, array $route){
      $this->routes[$path] = new Route($route);
   }

}