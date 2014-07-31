<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\Services\UserService;

class UserController {

   /**
    * @var \Rentatool\Application\Services\UserService
    */
   private $userService;

   /**
    * @param UserService $userService
    */
   public function __construct(UserService $userService) {
      $this->userService = $userService;
   }

   public function index() {
      $userService     = $this->userService;
      $userCollection  = $userService->index();
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setData($userCollection->toArray());

      return $response;

   }

   public function create(array $data) {
      $userService     = $this->userService;
      $user            = $userService->create($data);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setData($user->toArray())->setStatusCode(201);

      return $response;
   }

   public function read($id) {
      $userService     = $this->userService;
      $user            = $userService->read($id);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setData($user->toArray());

      return $response;
   }

   public function update($id, $requestData) {
      $userService     = $this->userService;
      $user            = $userService->update($id, $requestData);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setData($user->toArray());

      return $response;
   }

   public function delete($id) {
      $userService = $this->userService;
      $userService->delete($id);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setStatusCode(204);

      return $response;
   }
} 