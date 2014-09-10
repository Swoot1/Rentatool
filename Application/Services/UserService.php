<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Collections\UserCollection;
use Rentatool\Application\Collections\UserGroupCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Mappers\UserMapper;
use Rentatool\Application\Mappers\UserGroupConnectionMapper;
use Rentatool\Application\Models\User;

class UserService{
   private $userMapper;
   private $userValidationService;
   private $userGroupConnectionMapper;

   public function __construct(UserMapper $userMapper, UserValidationService $userValidationService, UserGroupConnectionMapper $userGroupConnectionMapper){
      $this->userMapper                = $userMapper;
      $this->userValidationService     = $userValidationService;
      $this->userGroupConnectionMapper = $userGroupConnectionMapper;
   }

   /**
    * @return UserCollection
    */
   public function index(){
      $userData = $this->userMapper->index();

      return new UserCollection($userData);
   }

   /**
    * @param array $data
    * @return User
    */
   public function create(array $data){
      $data         = $this->hashPassword($data);
      $userModel    = new User($data);
      $DBParameters = $userModel->getDBParameters();
      $this->userValidationService->validateUser($userModel);
      $userData = $this->userMapper->create($DBParameters);

      return new User($userData);
   }

   /**
    * @param array $data
    * @return array
    */
   private function hashPassword(array $data){
      $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

      return $data;
   }


   /**
    * @param $id
    * @return null|User
    */
   public function read($id){
      $user       = null;
      $result     = $this->userMapper->read($id);

      if ($result){
         $user           = new User($result);
         $userGroupsData = $this->userGroupConnectionMapper->getUserGroups($id);
         $user->setGroups(new UserGroupCollection($userGroupsData));
      }

      return $user;
   }

   /**
    * @param $email
    * @return null|User
    */
   public function getUserByEmail($email){
      $user       = null;
      $userData   = $this->userMapper->getUserByEmail($email);

      if ($userData){
         $user       = new User($userData);
         $userGroups = $this->userGroupConnectionMapper->getUserGroups($user->getId());
         $user->setGroups(new UserGroupCollection($userGroups));
      }

      return $user;
   }

   /**
    * @param $id
    * @param $requestData
    * @return null|User
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   public function update($id, $requestData){

      $this->checkThatUserExists($id);

      $requestData = $this->hashPassword($requestData);
      $userModel   = new User($requestData);
      $this->userValidationService->validateUser($userModel);

      $this->userMapper->update($userModel->getDBParameters());

      return $requestData ? new User($requestData) : null;
   }

   /**
    * @param $id
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   private function checkThatUserExists($id){
      $savedUser = $this->read($id);

      if ($savedUser == null){
         throw new NotFoundException('Användaren finns inte.');
      }

      return true;
   }

   /**
    * @param $id
    */
   public function delete($id){
      $this->userMapper->delete($id);
   }
} 