<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Collections\UserCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Mappers\UserMapper;
use Rentatool\Application\Models\User;

class UserService{
   private $userMapper;
   private $userValidationService;

   public function __construct(UserMapper $userMapper, UserValidationService $userValidationService){
      $this->userMapper            = $userMapper;
      $this->userValidationService = $userValidationService;
   }

   /**
    * @return UserCollection
    */
   public function index(){
      $userMapper = $this->userMapper;
      $userData   = $userMapper->index();

      return new UserCollection($userData);
   }

   /**
    * @param array $data
    * @return User
    */
   public function create(array $data){
      $data         = $this->hashPassword($data);
      $userModel    = new User($data);
      $userMapper   = $this->userMapper;
      $DBParameters = $userModel->getDBParameters();
      $this->userValidationService->validateUser($userModel);
      $result = $userMapper->create($DBParameters);

      return $userModel;
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
      $userMapper = $this->userMapper;
      $userData   = $userMapper->read($id);

      return $userData ? new User($userData) : null;
   }

   /**
    * @param $email
    * @return null|User
    */
   public function getUserByEmail($email){
      $userMapper = $this->userMapper;
      $userData   = $userMapper->getUserByEmail($email);

      return $userData = $userData ? new User($userData) : null;
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