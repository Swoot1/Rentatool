<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers\Routing;

use Rentatool\Application\ENFramework\Helpers\SessionManager;

class Route{
   private $controllerName;
   private $requiresAuthorization = true;
   private $get;
   private $post;
   private $put;
   private $delete;


   public function __construct(array $data){
      foreach ($data as $key => $value){
         $this->$key = $value;
      }
   }


   public function getController(){
      return $this->controllerName;
   }


   // TODO this function should be moved and improved.
   public function isUserAllowed(){
      return $this->requiresAuthorization == false || SessionManager::isUserLoggedIn();
   }
}