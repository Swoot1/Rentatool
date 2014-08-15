<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:14
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\Services\AuthorizationService;

class AuthorizationController{
   /**
    * @var \Rentatool\Application\Services\AuthorizationService
    */
   private $authorizationService;

   public function __construct(AuthorizationService $authorizationService, ResponseFactory $responseFactory){
      $this->authorizationService = $authorizationService;
      $this->response = $responseFactory->createResponse();
   }

   public function login(array $data){
      $authorization   = $this->authorizationService->login($data);
      $this->response->setResponseData($authorization);

      return $this->response;

   }

   public function logout(){
      $this->authorizationService->logout();

      return $this->response;
   }
} 