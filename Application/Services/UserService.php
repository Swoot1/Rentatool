<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Application\Services;


use Application\Collections\UserCollection;
use Application\Collections\UserGroupCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\Mappers\UserMapper;
use Application\Mappers\UserGroupConnectionMapper;
use Application\Models\User;

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
    * @return User
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   public function read($id){
      $result = $this->userMapper->read($id);

      if ($result === null){
         throw new NotFoundException('Kunde inte hitta användaren.');
      }

      $result['groups'] = $this->userGroupConnectionMapper->getUserGroups($id);

      return new User($result);
   }

   /**
    * @param $email
    * @return null|User
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   public function getUserByEmail($email){
      $userData = $this->userMapper->getUserByEmail($email);

      if ($userData === null){
         throw new NotFoundException('Kunde inte hitta användaren.');
      }

      $user       = new User($userData);
      $userGroups = $this->userGroupConnectionMapper->getUserGroups($user->getId());
      $user->setGroups(new UserGroupCollection($userGroups));

      return $user;
   }

   /**
    * @param $id
    * @param $requestData
    * @return null|User
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
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
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
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