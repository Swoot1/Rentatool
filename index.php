<?php
use Application\PHPFramework\DependencyInjection\DependencyInjection;
use Application\PHPFramework\Database\Factories\DatabaseConnectionFactory;
use Application\PHPFramework\ErrorHandling\ErrorHTTPStatusCodeFactory;
use Application\PHPFramework\ErrorHandling\Exceptions\UserIsNotAllowedException;
use Application\PHPFramework\Request\RequestDispatcher;
use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Response\Factories\ResponseFactory;

require_once 'Application/PHPFramework/SessionManager.php';
require_once 'Application/PHPFramework/Configurations/Configuration.php';
require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

SessionManager::startSession('User');

$databaseConnectionFactory = new DatabaseConnectionFactory();
$databaseConnection        = $databaseConnectionFactory->build();

try{
   $requestDispatcher = new RequestDispatcher();
   $requestModel      = $requestDispatcher->getRequestModel();

   $routeCollection = include_once 'Application/PHPFramework/Routing/RoutesConfiguration.php';
   $route           = $routeCollection->getRouteFromRequest($requestModel);

   if ($route->isUserAllowed()){
      $databaseConnection->beginTransaction();

      $dependencyInjectionContainer = simplexml_load_file('Application/PHPFramework/DependencyInjection/DependencyInjectionContainer.xml');
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
   $response->setResponseData(new Application\PHPFramework\ErrorHandling\ErrorTrace(array('message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'trace' => $exception->getTrace())));
   $response->sendResponse();

   $databaseConnection->rollBack();
}
