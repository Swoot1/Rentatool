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

class UserService
{
    private $userMapper;

    public function __construct(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    public function index()
    {
        $userMapper = $this->userMapper;
        $userData = $userMapper->index();

        return new UserCollection($userData);
    }

    public function create(array $data)
    {
        $data = $this->hashPassword($data);
        $userModel = new User($data);
        $userMapper = $this->userMapper;
        $DBParameters = $userModel->getDBParameters();
        $result = $userMapper->create($DBParameters);
        return $userModel;
    }

    private function hashPassword(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        return $data;
    }

    public function read($id)
    {
        $userMapper = $this->userMapper;
        $userData = $userMapper->read($id);

        return $userData ? new User($userData) : null;
    }

    public function getUserByEmail($email)
    {
        $userMapper = $this->userMapper;
        $userData = $userMapper->getUserByEmail($email);
        return $userData = $userData ? new User($userData) : null;
    }

    public function update($id, $requestData)
    {
        $userMapper = $this->userMapper;

        $savedUser = $this->read($id);

        if ($savedUser == null) {
            throw new NotFoundException('Användaren finns inte.');
        }
        $requestData = $this->hashPassword($requestData);
        $user = new User($requestData);

        $userMapper->update($user->getDBParameters());
        return $requestData ? new User($requestData) : null;
    }

    public function delete($id)
    {
        $userMapper = $this->userMapper;
        $userMapper->delete($id);
    }
} 