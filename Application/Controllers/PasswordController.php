<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:16
 */

namespace Application\Controllers;

use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\Request\Request;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\PasswordService;

class PasswordController{
   private $request;
   private $passwordService;
   private $response;

   public function __construct(Request $request, PasswordService $passwordService, ResponseFactory $responseFactory){
      $this->request;
      $this->passwordService = $passwordService;
      $this->response        = $responseFactory->build();
   }

   public function create(array $data){
      $GETParameters = $this->request->getGETParameters();

      if (array_key_exists('resetCode', $GETParameters)){
         $resetCode = $GETParameters['resetCode'];
      } else{
         throw new ApplicationException('Parameter för återställningskod saknas.');
      }


      $this->passwordService->create($resetCode, $data);

      return $this->response->addNotifier(array('message' => 'Lösenordet har återställts och du kan nu logga in'));
   }
} 