<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:54
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Controllers;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\ENFramework\Helpers\Notifier;
use Application\ENFramework\Helpers\ResponseFactory;
use Application\ENFramework\Models\Request;
use Application\Models\User;
use Application\Models\UserGroup;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\Models\UserGroupConnection;
use Application\Services\UserGroupService;
use Application\Services\UserService;

class UserGroupController{

   private $request;
   private $userGroupService;
   private $response;


   public function __construct(Request $request, UserGroupService $userGroupService, UserService $userService, ResponseFactory $responseFactory){
      $this->request          = $request;
      $this->userGroupService = $userGroupService;
      $this->userService      = $userService;
      $this->response         = $responseFactory->createResponse();
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

      $this->response->setResponseData($userGroup);
      $this->response->addNotifier(['message' => 'Gruppen har skapats.']);

      return $this->response;
   }


   public function update($id, array $data){
      $userGroup = $this->userGroupService->update($id, $data);

      $this->response->setResponseData($userGroup);
      $this->response->addNotifier(['message' => 'Gruppen har uppdaterats.']);

      return $this->response;
   }


   public function delete($id){
      $this->userGroupService->delete($id);
      $this->response->setStatusCode(204);

      return $this->response;
   }


   public function addMember(array $data){
      $userGroupConnection = new UserGroupConnection($data);

      $user      = $this->userService = $this->userService->read($userGroupConnection->getUserId());
      $userGroup = $this->userGroupService->read($userGroupConnection->getGroupId());

      $this->userGroupService->addMember($userGroupConnection);

      $message = sprintf('%s har lagts till i %s', $user->getUsername(), $userGroup->getName());
      $this->response->addNotifier(['message' => $message]);

      return $this->response;
   }


   public function removeMember(array $data){
      $userGroupConnection = new UserGroupConnection($data);

      $user      = $this->userService = $this->userService->read($userGroupConnection->getUserId());
      $userGroup = $this->userGroupService->read($userGroupConnection->getGroupId());

      $this->userGroupService->removeMember($userGroupConnection);

      $message = sprintf('%s har tagits bort från %s', $user->getUsername(), $userGroup->getName());
      $this->response->addNotifier(['message' => $message]);

      return $this->response;
   }

}