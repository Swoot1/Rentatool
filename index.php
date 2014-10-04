<?php
use Application\ENFramework\DependencyInjection\DependencyInjection;
use Application\ENFramework\Helpers\Database\Factories\DatabaseConnectionFactory;
use Application\ENFramework\Helpers\ErrorHandling\ErrorHTTPStatusCodeFactory;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Application\ENFramework\RequestDispatcher;
use Application\ENFramework\SessionManager;
use Application\ENFramework\Response\Factories\ResponseFactory;

require_once 'Application/ENFramework/SessionManager.php';
require_once 'Application/ENFramework/Configurations/Configuration.php';
require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

SessionManager::startSession('User');

$databaseConnectionFactory = new DatabaseConnectionFactory();
$databaseConnection        = $databaseConnectionFactory->build();

try{
   $requestDispatcher = new RequestDispatcher();
   $requestModel      = $requestDispatcher->getRequestModel();

   $routeCollection = include_once 'Application/ENFramework/Helpers/Routing/RoutesConfiguration.php';
   $route           = $routeCollection->getRouteFromRequest($requestModel);

   if ($route->isUserAllowed()){
      $databaseConnection->beginTransaction();

      $dependencyInjectionContainer = simplexml_load_file('Application/ENFramework/DependencyInjection/DependencyInjectionContainer.xml');
      $dependencyInjection          = new DependencyInjection($dependencyInjectionContainer);
      $controller                   = $dependencyInjection->getInstantiatedClass($route->getController(), $requestModel);
      $response                     = $requestModel->callControllerMethod($controller);
      $response->sendResponse();

      $databaseConnection->commit();
   } else{
      throw new UserIsNotAllowedException('Du måste logga in för att fortsätta.');
   }

} catch (Exception $exception){
   $errorHTTPStatusCodeFactory = new ErrorHTTPStatusCodeFactory($exception);
   $HTTPStatusCode             = $errorHTTPStatusCodeFactory->getHTTPStatusCode();
   $responseFactory            = new ResponseFactory();
   $response                   = $responseFactory->createResponse();
   $response->setStatusCode($HTTPStatusCode);
   $response->setResponseData(new Application\ENFramework\Helpers\ErrorHandling\ErrorTrace(array('message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'trace' => $exception->getTrace())));
   $response->sendResponse();

   $databaseConnection->rollBack();
}
