<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:14
 */

namespace Application\Controllers;

use Application\ENFramework\Models\Request;
use Application\ENFramework\Response\Factories\ResponseFactory;
use Application\Services\AuthorizationService;

class AuthorizationController{
   /**
    * @var \Application\Services\AuthorizationService
    */
   private $request;
   private $authorizationService;
   private $response;

   // TODO remove $request from controllers that don't use it
   public function __construct(Request $request, AuthorizationService $authorizationService, ResponseFactory $responseFactory){
      $this->request              = $request;
      $this->authorizationService = $authorizationService;
      $this->response             = $responseFactory->createResponse();
   }

   public function login(array $data){
      $authorization = $this->authorizationService->login($data);
      $this->response->setResponseData($authorization);

      return $this->response;

   }

   public function logout(){
      $this->authorizationService->logout();

      return $this->response;
   }
} 