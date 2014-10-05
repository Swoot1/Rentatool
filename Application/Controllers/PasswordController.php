<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:16
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\PasswordService;

class PasswordController{
   /**
    * @var \Application\Services\FileService
    */
   private $passwordService;
   private $response;

   public function __construct(PasswordService $passwordService, ResponseFactory $responseFactory){
      $this->passwordService = $passwordService;
      $this->response        = $responseFactory->build();
   }

   public function create(array $data){
      $this->passwordService->create($data);

      return $this->response->addNotifier(array('message' => 'Lösenordet har återställts och du kan nu logga in'));
   }
} 