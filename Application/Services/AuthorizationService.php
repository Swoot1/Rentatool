<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:15
 */

namespace Application\Services;


use Application\Models\Login;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\SessionManager;
use Application\Models\Authorization;

class AuthorizationService{
   private $userService;
   private $sessionManager;

   public function __construct(UserService $userService, SessionManager $sessionManager){
      $this->userService    = $userService;
      $this->sessionManager = $sessionManager;
   }

   public function login($data){
      $login = new Login($data);
      $user  = $this->getLoginUser($login);
      $this->sessionManager->setUserData($user->toArray());

      return new Authorization(['isLoggedIn' => true, 'userId' => $user->getId()]);
   }

   private function getLoginUser(Login $login){
      $user         = $this->userService->getUserByEmail($login->getEmail());
      $invalidLogin = $user === null || $user->isValidPassword($login->getPassword()) == false;

      if ($invalidLogin){
         throw new ApplicationException('Fel e-postadress.');
      }

      return $user;
   }

   public function logout(){
      $this->sessionManager->endSession();
   }

   public function confirmEmail($email){
      $this->userService->confirmEmail($email);
   }
} 