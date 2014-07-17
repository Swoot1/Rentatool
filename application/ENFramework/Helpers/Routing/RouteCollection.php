<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers\Routing;


class RouteCollection{

   private $routes = [];


   public function __construct(array $routes){
      foreach ($routes as $path => $route){
         $this->addRoute($path, $route);
      }
   }


   public function getRoute($route){
      if (!array_key_exists($route, $this->routes)){
         return false;
      }

      return $this->routes[$route];
   }


   private function addRoute($path, array $route){
      $this->routes[$path] = new Route($route);
   }

}