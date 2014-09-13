<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers\Routing;

use Application\ENFramework\Models\Request;

class RouteCollection {

   private $routes = [];


   public function __construct(array $routes) {
      foreach ($routes as $path => $route) {
         $this->addRoute($path, $route);
      }
   }

   /**
    * Returns the route object that corresponds with the request options.
    * @param Request $request
    * @return bool
    */
   public function getRouteFromRequest(Request $request) {
      $resource = $request->getResource();
      if (!array_key_exists($resource, $this->routes)) {
         return false;
      }

      $route = $this->routes[$resource];

      $route = $request->getAction() ? $route->getSubRoute($request) : $route;
      $route->validateRequestMethod($request);

      return $route;
   }

   private function addRoute($path, array $route) {
      $this->routes[$path] = new Route($route);
   }

}