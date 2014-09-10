<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers\Routing;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\ENFramework\Models\Request;

class Route {
   private $controllerName;
   private $requestMethodCollection;
   private $subRoutesCollection;
   private $accessRule;

   public function __construct(array $data) {
      foreach ($data as $key => $value) {
         $this->$key = $value;
      }
   }


   public function getController() {
      return $this->controllerName;
   }

   /**
    * Validate that the request method is allowed for the route.
    * @param Request $request
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   public function validateRequestMethod(Request $request) {
      $isValidRequestMethod = $this->requestMethodCollection->isValidRequestMethod($request->getRequestMethod());

      if ($isValidRequestMethod === false) {
         throw new ApplicationException('Ogiltig request method.');
      }

      return true;
   }

   public function getSubRoute(Request $request) {
      return $this->subRoutesCollection->getSubRouteFromRequest($request);
   }

   public function isUserAllowed() {
      $allowed = false;

      if(SessionManager::isUserLoggedIn() && !is_null($this->accessRule)) {
         $allowed = $this->accessRule->isAccessAllowed(SessionManager::getCurrentUser());

         if(!$allowed) {
            throw new UserIsNotAllowedException('Du saknar behörighet för denna resurs.');
         }
      }

      return is_null($this->accessRule) || $allowed;
   }
}