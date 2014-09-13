<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/08/14
 * Time: 15:57
 */

namespace Application\Services;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\Mappers\UserValidationMapper;
use Application\Models\User;

class UserValidationService{

   private $userValidationMapper;

   public function __construct(UserValidationMapper $userValidationMapper){
      $this->userValidationMapper = $userValidationMapper;
   }

   /**
    * @param User $userModel
    * @return bool
    */
   public function validateUser(User $userModel){
      $this->checkUniqueUsername($userModel);
      $this->checkUniqueEmail($userModel);

      return true;
   }

   /**
    * @param User $userModel
    * @return bool
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkUniqueUsername(User $userModel){
      $isUniqueUsername = $this->userValidationMapper->isUniqueUsername($userModel->getId(), $userModel->getUsername());

      if ($isUniqueUsername === false){
         throw new ApplicationException('Användarnamnet är redan upptaget.');
      }

      return true;
   }

   /**
    * @param User $userModel
    * @return bool
    * @throws \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkUniqueEmail(User $userModel){
      $isUniqueEmail = $this->userValidationMapper->isUniqueEmail($userModel->getId(), $userModel->getEmail());

      if ($isUniqueEmail === false){
         throw new ApplicationException('E-mailadressen används redan.');
      }

      return true;
   }
} 
