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

class AuthorizationController {
   /**
    * @var \Rentatool\Application\Services\AuthorizationService
    */
   private $authorizationService;

   public function __construct(AuthorizationService $authorizationService) {
      $this->authorizationService = $authorizationService;
   }

   public function login(array $data) {
      $authorization   = $this->authorizationService->login($data);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setResponseData($authorization);

      return $response;

   }

   public function logout() {
      $this->authorizationService->logout();
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();

      return $response;
   }
} 