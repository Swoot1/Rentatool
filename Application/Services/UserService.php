<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Application\Services;


use Application\Collections\UserCollection;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;
use Application\Mappers\UserMapper;
use Application\Models\User;
use Application\PHPFramework\Validation\EmailValidation;

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
      $userData = $this->userMapper->index();

      return new UserCollection($userData);
   }

   /**
    * @param array $data
    * @return User
    */
   public function create(array $data){
      $userModel    = new User($data);
      $DBParameters = $userModel->getDBParameters();
      $DBParameters = $this->hashPassword($DBParameters);
      $this->userValidationService->validateUser($userModel);
      $userData = $this->userMapper->create($DBParameters);

      return new User($userData);
   }

   /**
    * @param array $data
    * @return array
    */
   private function hashPassword(array $data){

      // TODO exception om password inte är satt.
      $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

      return $data;
   }


   /**
    * @param $id
    * @return User
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    */
   public function read($id){
      $result = $this->userMapper->read($id);

      if ($result === null){
         throw new NotFoundException('Kunde inte hitta användaren.');
      }

      return new User($result);
   }

   public function getUserByEmail($email){
      $this->validateEmail($email);
      $userData = $this->userMapper->getUserByEmail($email);

      if ($userData === null){
         throw new NotFoundException('Kunde inte hitta användaren.');
      }

      return new User($userData);
   }

   private function validateEmail($email){
      $emailValidation = new EmailValidation(array('genericName' => 'e-postadress'));
      $emailValidation->validate($email);

      return true;
   }

   public function update($id, $requestData){

      $this->checkThatUserExists($id);
      $requestData = $this->hashPassword($requestData);
      $userModel   = new User($requestData);
      $this->userValidationService->validateUser($userModel);

      $this->userMapper->update($userModel->getDBParameters());

      return new User($requestData);
   }

   private function checkThatUserExists($id){
      $savedUser = $this->read($id);

      if ($savedUser == null){
         throw new NotFoundException('Användaren finns inte.');
      }

      return true;
   }

   public function delete($id){
      $this->userMapper->delete($id);
   }
} 