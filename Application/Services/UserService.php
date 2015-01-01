<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Application\Services;


use Application\Collections\UserCollection;
use Application\Factories\MailFactory;
use Application\Models\ConfirmEmail;
use Application\Models\MailContent;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
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
      $userModel = new User($data);
      $this->userValidationService->validateUser($userModel);
      $DBParameters             = $userModel->getDBParameters();
      $DBParameters['password'] = $this->hashPassword($userModel->getPassword());
      $userData                 = $this->userMapper->create($DBParameters);

      return new User($userData);
   }

   public function signUp(array $data, MailFactory $mailFactory){
      $data['hasAdministrativeAccess'] = false;
      $data['hasConfirmedEmail']       = false;
      $user                            = $this->create($data);
      $this->sendWelcomeMessage($mailFactory, $user);

      return $user;
   }

   private function sendWelcomeMessage(MailFactory $mailFactory, User $user){

      $linkAddress = sprintf('%s/rentatool/#/authorization/confirmemail?email=%s', $_SERVER['SERVER_NAME'], $user->getEmail());
      $mailContent = new MailContent(array(
                                        'subject'        => 'Återställning av lösenord.',
                                        'recipientEmail' => $user->getEmail(),
                                        'bodyHTML'       => sprintf('Välkommen! Bekräfta din email: <a href="%s">Klicka här!</a>', $linkAddress),
                                        'bodyPlainText'  => sprintf('Öppna den här adressen i din webbläsare för att återställa ditt lösenord %s', $linkAddress)
                                     ));

      $mail = $mailFactory->build($mailContent);

      if (!$mail->send()){
         throw new ApplicationException(sprintf('Mailer Error: %s', $mail->ErrorInfo));
      }
   }

   public function confirmEmail($email){
      $this->validateEmail($email);
      $this->userMapper->confirmEmail($email);

      return new ConfirmEmail();
   }

   private function hashPassword($password){

      if (is_string($password)){
         $password = password_hash($password, PASSWORD_BCRYPT);
      } else{
         throw new ApplicationException('Ogiltigt lösenord.');
      }

      return $password;
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
      $userModel = new User($requestData);
      $this->userValidationService->validateUser($userModel);
      $DBParameters             = $userModel->getDBParameters();
      $DBParameters['password'] = $this->hashPassword($userModel->getPassword());
      $this->userMapper->update($DBParameters);

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

   // TODO this class is to long
} 