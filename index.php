<?php

require_once 'Application/Helpers/Autoloader.php';
require_once 'Application/Helpers/Configuration.php';

putenv('TMP=C:/temp');
//http://richardmiller.co.uk/2011/07/07/dependency-injection-moving-from-basics-to-container/
$configuration = new \GoFish\Application\Helpers\Configuration();
$configuration->setUpConfiguration();

$autoLoader = new \GoFish\Application\Helpers\Autoloader();
$autoLoader->setUpAutoLoader();

$requestDispatcher = new \GoFish\Application\Helpers\RequestDispatcher();
$requestModel = $requestDispatcher->getRequestModel();


$DIXML = simplexml_load_file('Application/Helpers/dependencyinjection.xml');

$routing = new \GoFish\Application\Helpers\Routing($requestModel, $DIXML);
$routeCollection = include_once 'Application/Helpers/RoutesConfiguration.php';
$route = $routeCollection->getRoute($requestModel);

if ($route) {
    $result = $routing->callMethod($route);
    $result = json_encode($result ? $result->toArray() : array(), JSON_UNESCAPED_UNICODE);
    header('Content-Type: Application/json; charset=utf-8');
    echo $result;
} else {
    include 'GoFish\Application\Templates\indexHTML.php';
    $result = json_encode(array());
}










































