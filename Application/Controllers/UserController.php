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
   private $sessionManager;

   /**
    * @param UserService $userService
    * @param ResponseFactory $responseFactory
    * @param SessionManager $sessionManager
    */
   public function __construct(UserService $userService, ResponseFactory $responseFactory, SessionManager $sessionManager){
      $this->userService    = $userService;
      $this->response       = $responseFactory->build();
      $this->sessionManager = $sessionManager;
   }

   public function index(){
      $userCollection = $this->userService->index();

      return $this->response->setResponseData($userCollection);

   }

   public function create(array $data){
      $user = $this->userService->create($data);

      return $this->response->addNotifier(['message' => 'Användaren har skapats.'])
                            ->setResponseData($user)
                            ->setStatusCode(201);
   }

   public function read($id){
      $user = $this->userService->read($id);

      return $this->response->setResponseData($user);
   }

   public function update($id, $requestData){
      $user = $this->userService->update($id, $requestData);

      return $this->response->setResponseData($user)
                            ->addNotifier(['message' => 'Användaren har uppdaterats.']);
   }

   public function delete($id){
      $this->userService->delete($id);

      return $this->response->setStatusCode(204);
   }

   public function currentUser(){
      $currentUser = $this->sessionManager->getCurrentUser();

      return $this->response->setResponseData($currentUser);
   }
} 