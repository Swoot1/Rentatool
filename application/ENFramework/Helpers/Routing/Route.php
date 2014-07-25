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
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\ENFramework\Models\Request;

class Route {
   private $controllerName;
   private $requiresAuthorization = true;
   private $requestMethodCollection;
   private $subRoutesCollection;

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
   public function validateRequest(Request $request) {
      $isValidRequestMethod = $this->requestMethodCollection->isValidRequestMethod($request->getRequestMethod());

      if($isValidRequestMethod === false){
         throw new ApplicationException('Ogiltig request method.');
      }

      return true;
   }


   // TODO this function should be moved and improved.
   public function isUserAllowed() {
      return $this->requiresAuthorization == false || SessionManager::isUserLoggedIn();
   }
}