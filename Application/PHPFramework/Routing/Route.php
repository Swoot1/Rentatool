<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Routing;

use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Request\Request;

class Route{
   private $controllerName;
   private $requestMethodCollection;
   private $subRoutesCollection;
   private $accessRule;

   public function __construct(array $data){
      foreach ($data as $key => $value){
         $this->$key = $value;
      }
   }


   public function getController(){
      return $this->controllerName;
   }

   /**
    * Validate that the request method is allowed for the route.
    * @param Request $request
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   public function validateRequestMethod(Request $request){
      $isValidRequestMethod = $this->requestMethodCollection->isValidRequestMethod($request->getRequestMethod());

      if ($isValidRequestMethod === false){
         throw new ApplicationException('Ogiltig request method.');
      }

      return true;
   }


   public function getSubRoute(Request $request){
      return $this->subRoutesCollection->getSubRouteFromRequest($request);
   }


   public function isUserAllowed(User $currentUser){
      if (!is_null($this->accessRule)){
         $allowed = $this->accessRule->isAccessAllowed($currentUser);

         if (!$allowed){
            throw new UserIsNotAllowedException('Du saknar behörighet för denna resurs.');
         }
      }

      return true;
   }
}