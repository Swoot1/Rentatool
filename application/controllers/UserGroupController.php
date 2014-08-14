<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:54
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\Notifier;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\Services\UserGroupService;

class UserGroupController{

   private $userGroupService;


   public function __construct(UserGroupService $userGroupService){
      $this->userGroupService = $userGroupService;
   }


   public function index(){
      $userGroups = $this->userGroupService->index();

      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setResponseData($userGroups);

      return $response;
   }


   public function read($id){
      $userGroup = $this->userGroupService->read($id);

      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $response->setResponseData($userGroup);

      return $response;
   }


   public function create(array $data){
      $userGroup = $this->userGroupService->create($data);

      $responseFactory = new ResponseFactory();
      $successNotifier = new Notifier(['message' => 'Gruppen har skapats.']);
      $response        = $responseFactory->createResponse();

      $response->setResponseData($userGroup);
      $response->addNotifier($successNotifier);

      return $response;
   }


   public function update($id, array $data){
      $userGroup = $this->userGroupService->update($id, $data);

      $responseFactory = new ResponseFactory();
      $successNotifier = new Notifier(['message' => 'Gruppen har uppdaterats.']);
      $response        = $responseFactory->createResponse();

      $response->setResponseData($userGroup);
      $response->addNotifier($successNotifier);

      return $response;
   }


   public function delete($id){
      $this->userGroupService->delete($id);

      $responseFactory = new ResponseFactory();
      $successNotifier = new Notifier(['message' => 'Gruppen har tagits bort.']);
      $response        = $responseFactory->createResponse();

      $response->addNotifier($successNotifier);
      $response->setStatusCode(204);

      return $response;
   }

}