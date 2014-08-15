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


   public function __construct(UserGroupService $userGroupService, ResponseFactory $responseFactory){
      $this->userGroupService = $userGroupService;
      $this->response = $responseFactory->createResponse();
   }


   public function index(){
      $userGroups = $this->userGroupService->index();
      $this->response->setResponseData($userGroups);

      return $this->response;
   }


   public function read($id){
      $userGroup = $this->userGroupService->read($id);
      $this->response->setResponseData($userGroup);

      return $this->response;
   }


   public function create(array $data){
      $userGroup = $this->userGroupService->create($data);
      $successNotifier = new Notifier(['message' => 'Gruppen har skapats.']);

      $this->response->setResponseData($userGroup);
      $this->response->addNotifier($successNotifier);

      return $this->response;
   }


   public function update($id, array $data){
      $userGroup = $this->userGroupService->update($id, $data);
      $successNotifier = new Notifier(['message' => 'Gruppen har uppdaterats.']);

      $this->response->setResponseData($userGroup);
      $this->response->addNotifier($successNotifier);

      return $this->response;
   }


   public function delete($id){
      $this->userGroupService->delete($id);

      $successNotifier = new Notifier(['message' => 'Gruppen har tagits bort.']);
      $this->response->addNotifier($successNotifier);
      $this->response->setStatusCode(204);

      return $this->response;
   }

}