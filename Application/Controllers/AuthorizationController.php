<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:14
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\AuthorizationService;

class AuthorizationController{
   /**
    * @var \Application\Services\AuthorizationService
    */
   private $authorizationService;
   private $response;

   public function __construct(AuthorizationService $authorizationService, ResponseFactory $responseFactory){
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