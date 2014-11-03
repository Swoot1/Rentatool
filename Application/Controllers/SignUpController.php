<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/11/14
 * Time: 19:35
 */

namespace Application\Controllers;


use Application\Factories\MailFactory;
use Application\PHPFramework\Configurations\MailConfiguration;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\UserService;

class SignUpController{
   /**
    * @var \Application\Services\UserService
    */
   private $userService;
   private $response;

   /**
    * @param UserService $userService
    * @param ResponseFactory $responseFactory
    */
   public function __construct(UserService $userService, ResponseFactory $responseFactory){
      $this->userService    = $userService;
      $this->response       = $responseFactory->build();
   }


   public function create(array $data){
      $mailFactory = new MailFactory(new \PHPMailer(), new MailConfiguration());
      $user = $this->userService->signUp($data, $mailFactory);

      return $this->response->addNotifier(['message' => 'Kontot har skapats.'])
                            ->setResponseData($user)
                            ->setStatusCode(201);
   }
} 