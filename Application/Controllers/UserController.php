<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Application\Controllers;

use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\UserService;

class UserController{

   /**
    * @var \Application\Services\UserService
    */
   private $userService;
   private $response;

   /**
    * @param UserService $userService
    * @param ResponseFactory $responseFactory
    */
   public function __construct(UserService $userService, ResponseFactory $responseFactory){
      $this->userService = $userService;
      $this->response    = $responseFactory->createResponse();
   }

   public function index(){
      $userCollection = $this->userService->index();
      $this->response->setResponseData($userCollection);

      return $this->response;

   }

   public function create(array $data){
      $user = $this->userService->create($data);
      $this->response->addNotifier(['message' => 'Användaren har skapats.']);
      $this->response->setResponseData($user)->setStatusCode(201);

      return $this->response;
   }

   public function read($id){
      $user = $this->userService->read($id);
      $this->response->setResponseData($user);

      return $this->response;
   }

   public function update($id, $requestData){
      $user = $this->userService->update($id, $requestData);
      $this->response->setResponseData($user)->addNotifier(['message' => 'Användaren har uppdaterats.']);

      return $this->response;
   }

   public function delete($id){
      $this->userService->delete($id);
      $this->response->setStatusCode(204);

      return $this->response;
   }

   public function currentUser(){
      $currentUser = SessionManager::getCurrentUser();

      return $this->response->setResponseData($currentUser);
   }
} 