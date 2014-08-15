<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Notifier;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\Services\UserService;

class UserController{

   /**
    * @var \Rentatool\Application\Services\UserService
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
      $userService    = $this->userService;
      $userCollection = $userService->index();
      $this->response->setResponseData($userCollection);

      return $this->response;

   }

   public function create(array $data){
      $userService     = $this->userService;
      $user            = $userService->create($data);
      $successNotifier = new Notifier(array('message' => 'Användaren har skapats.'));
      $this->response->addNotifier($successNotifier);
      $this->response->setResponseData($user)->setStatusCode(201);

      return $this->response;
   }

   public function read($id){
      $userService = $this->userService;
      $user        = $userService->read($id);
      $this->response->setResponseData($user);

      return $this->response;
   }

   public function update($id, $requestData){
      $userService     = $this->userService;
      $user            = $userService->update($id, $requestData);
      $successNotifier = new Notifier(array('message' => 'Användaren har uppdaterats.'));
      $this->response->setResponseData($user)->addNotifier($successNotifier);

      return $this->response;
   }

   public function delete($id){
      $userService = $this->userService;
      $userService->delete($id);
      $successNotifier = new Notifier(array('message' => 'Användaren har tagits bort.'));
      $this->response->addNotifier($successNotifier);
      $this->response->setStatusCode(204);

      return $this->response;
   }
} 