<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:21
 */

namespace Application\Services;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\ENFramework\Helpers\Validation\EmailValidation;
use Application\Factories\ResetPasswordFactory;
use Application\Mappers\ResetPasswordMapper;

class ResetPasswordService{

   private $resetPasswordMapper;
   private $resetPasswordFactory;
   private $userService;

   public function __construct(ResetPasswordMapper $resetPasswordMapper, ResetPasswordFactory $resetPasswordFactory, UserService $userService){
      $this->resetPasswordMapper  = $resetPasswordMapper;
      $this->resetPasswordFactory = $resetPasswordFactory;
      $this->userService = $userService;
   }

   public function create(array $data){
      $email       = $this->getEmailFromArray($data);
      $user = $this->userService->getUserByEmail($email);

      if (!$user){
         throw new NotFoundException('Det finns ingen användare med den e-postadressen.');
      }

      $resetPassword = $this->resetPasswordFactory->build($user);
      $this->resetPasswordMapper->create($resetPassword->getDBParameters());
      mail('elinhejnilsson@gmail.com', 'Hyrdet', 'Hej');
   }

   private function getEmailFromArray(array $data){

      $email = array_key_exists('email', $data) ? $data['email'] : false;

      $emailValidation = new EmailValidation(array('genericName' => 'e-postaddress'));
      $emailValidation->validate($email);

      return $email;
   }
} 