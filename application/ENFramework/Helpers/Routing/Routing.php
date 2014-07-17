<?php
/**
 * User: Elin
 * Date: 2014-06-21
 * Time: 11:19
 */

namespace Rentatool\Application\ENFramework\Helpers\Routing;


use Rentatool\Application\ENFramework\Helpers\DependencyInjection\DependencyInjection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException;
use Rentatool\Application\ENFramework\Models\Request;

class Routing
{

    private $request;
    private $dependencyInjector;

    public function __construct(Request $request, \SimpleXMLElement $dependencyInjector)
    {
        $this->request = $request;
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws ApplicationException
     */
    public function callMethod(Route $route)
    {
        $controller = $this->getController($route);
        $requestURIAsArray = explode('/', $this->request->getRequestURI());
        $id = isset($requestURIAsArray[1]) ? $requestURIAsArray[1] : false;
        $requestMethod = $this->request->getRequestMethod();
        $requestData = $this->request->getRequestData();

        if ($requestMethod === 'GET') {
            if ($id) {

                if(is_numeric($id)){
                    $result = $controller->read($id);
                }else{
                    $isSubString = array_key_exists(1, $requestURIAsArray) && preg_match('/^[a-z0-9]+$/', $requestURIAsArray[1], $matches);

                    if($isSubString){
                        if(method_exists($controller, $matches[0])){
                            $result = call_user_func(array($controller, $matches[0]), $requestData);
                        }else{
                            throw new NoSuchRouteException('Ogiltig url.');
                        }
                    }
                }

            } else {
                $result = $controller->index();
            }
        } else if ($requestMethod === 'DELETE') {
            if ($id) {
                $result = $controller->delete($id);
            } else {
                throw new ApplicationException('Ange ett id för borttagning.');
            }
        } else if ($requestMethod === 'POST') {
            $result = $this->casePOST($requestData, $controller, $requestURIAsArray);
        } else if ($requestMethod === 'PUT') {
            if ($id) {
                $result = $controller->update($id, $requestData);
            } else {
                throw new ApplicationException('Ange ett id för uppdatering.');
            }
        } else {
            throw new NoSuchRouteException('Ogiltigt request.');
        }

        return $result;

    }

    private function casePOST(array $requestData, $controller, array $requestURIAsArray){

        $isSubString = array_key_exists(1, $requestURIAsArray) && preg_match('/^[a-z0-9]+$/', $requestURIAsArray[1], $matches);

        if($isSubString){
            if(method_exists($controller, $matches[0])){
                $result = call_user_func(array($controller, $matches[0]), $requestData);
            }else{
                throw new NoSuchRouteException('Ogiltig url.');
            }
        }else{
            $result = $controller->create($requestData);
        }

        return $result;
    }

    /**
     * @param String $controllerName
     * @return null|object
     */
    private function getController(Route $route)
    {
        $dependencyInjectionContainer = new DependencyInjection($this->dependencyInjector);
        return $dependencyInjectionContainer->getInstantiatedClass($route->getController());
    }
} 