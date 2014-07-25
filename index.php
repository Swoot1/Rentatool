<?php
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\ErrorHTTPStatusCodeFactory;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Rentatool\Application\ENFramework\Helpers\RequestDispatcher;
use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\Routing\Routing;
use Rentatool\Application\ENFramework\Helpers\SessionManager;

require_once 'Application/ENFramework/Helpers/SessionManager.php';
require_once 'Application/ENFramework/Helpers/Configuration.php';

SessionManager::startSession('User');

try{
   $requestDispatcher = new RequestDispatcher();
   $requestModel      = $requestDispatcher->getRequestModel();

   $routeCollection = include_once 'Application/ENFramework/Helpers/Routing/RoutesConfiguration.php';
   $route           = $routeCollection->getRoute($requestModel);

   if ($route){
      if ($route->isUserAllowed()){
         $dependencyInjectionContainer = simplexml_load_file('Application/ENFramework/Helpers/DependencyInjection/DependencyInjectionContainer.xml');
         $routing         = new Routing($requestModel, $dependencyInjectionContainer);
         $response = $routing->callMethod($route);
         $response->sendResponse();
      } else{
         throw new UserIsNotAllowedException('Du måste logga in för att fortsätta.');
      }
   } else{
      include 'Application/Templates/indexHTML.php';
   }
} catch (Exception $exception){
   $errorHTTPStatusCodeFactory = new ErrorHTTPStatusCodeFactory($exception);
   $HTTPStatusCode             = $errorHTTPStatusCodeFactory->getHTTPStatusCode();
   $response                   = new Response();
   $response->setStatusCode($HTTPStatusCode);
   $response->setData(array('message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'trace' => $exception->getTrace()));
   $response->sendResponse();
}










































