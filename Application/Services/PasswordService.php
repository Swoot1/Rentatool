<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:17
 */

namespace Application\Services;

use Application\Mappers\PasswordMapper;
use Application\Models\Password;

class PasswordService{

   private $passwordMapper;
   private $resetPasswordService;

   public function __construct(PasswordMapper $passwordMapper, ResetPasswordService $resetPasswordService){
      $this->passwordMapper       = $passwordMapper;
      $this->resetPasswordService = $resetPasswordService;
   }

   public function create($resetCode, array $data){
      $password     = new Password($data);
      $activeReset  = $this->resetPasswordService->readActiveResetPassword($resetCode);
      $DBParameters = $this->hashPassword($password->getDBParameters());
      $this->passwordMapper->create(array_merge($DBParameters, array('userId' => $activeReset->getUserId())));
      $this->resetPasswordService->delete($activeReset->getId());
   }

   /**
    * @param array $data
    * @return array
    */
   private function hashPassword(array $data){
      $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

      return $data;
   }
} 