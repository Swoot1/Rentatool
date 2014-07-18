<?php
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\ErrorHTTPStatusCodeFactory;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Rentatool\Application\ENFramework\Helpers\SessionManager;

require_once 'Application/ENFramework/Helpers/SessionManager.php';
require_once 'Application/ENFramework/Helpers/Configuration.php';

SessionManager::startSession('User');

try{
   $requestDispatcher = new \Rentatool\Application\ENFramework\Helpers\RequestDispatcher();
   $requestModel      = $requestDispatcher->getRequestModel();

   $dependencyInjectionContainer = simplexml_load_file('Application/ENFramework/Helpers/DependencyInjection/DependencyInjectionContainer.xml');

   $routing         = new \Rentatool\Application\ENFramework\Helpers\Routing\Routing($requestModel, $dependencyInjectionContainer);
   $routeCollection = include_once 'Application/ENFramework/Helpers/Routing/RoutesConfiguration.php';
   $route           = $routeCollection->getRoute($requestModel->getResource());

   if ($route){
      if ($route->isUserAllowed()){
         $response = $routing->callMethod($route);
         $response->sendResponse();
      } else{
         throw new UserIsNotAllowedException('Du måste logga in för att fortsätta.');
      }
   } else{
      include 'Application\Templates\indexHTML.php';
   }
} catch (Exception $exception){
   $errorHTTPStatusCodeFactory = new ErrorHTTPStatusCodeFactory($exception);
   $HTTPStatusCode             = $errorHTTPStatusCodeFactory->getHTTPStatusCode();
   $response                   = new \Rentatool\Application\ENFramework\Helpers\Response();
   $response->setStatusCode($HTTPStatusCode);
   $response->setData(array('message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'trace' => $exception->getTrace()));
   $response->sendResponse();
}










































