<?php
/**
 * User: Elin
 * Date: 2014-07-11
 * Time: 12:15
 */

namespace GoFish\Application\Services;


use GoFish\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use GoFish\Application\ENFramework\Helpers\SessionManager;
use GoFish\Application\Models\Authorization;

class AuthorizationService
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login($data)
    {
        $user = $this->userService->getUserByEmail($data['email']);
        $invalidLogin = $user === null || $user->isValidPassword($data['password']) == false;

        if ($invalidLogin) {
            throw new ApplicationException('Fel e-postadress eller användarnamn.');
        } else {
            SessionManager::setUserData($user->toArray());
        }

        return new Authorization(array('isLoggedIn' => true));
    }

    public function logout()
    {
        SessionManager::endSession();
    }
} 