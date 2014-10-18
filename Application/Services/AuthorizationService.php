<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:15
 */

namespace Application\Services;


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
      // TODO validation
      $user         = $this->userService->getUserByEmail($data['email']);
      $invalidLogin = $user === null || $user->isValidPassword($data['password']) == false;

      if ($invalidLogin){
         throw new ApplicationException('Fel e-postadress eller användarnamn.');
      }

      $this->sessionManager->setUserData($user->toArray());

      return new Authorization(array('isLoggedIn' => true));
   }

   public function logout(){
      $this->sessionManager->endSession();
   }
} 