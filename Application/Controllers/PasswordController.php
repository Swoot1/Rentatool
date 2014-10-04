<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:16
 */

namespace Application\Controllers;

use Application\ENFramework\Request\Request;
use Application\ENFramework\Response\Factories\ResponseFactory;
use Application\Services\PasswordService;

class PasswordController {
   /**
    * @var \Application\Services\RentalObjectService
    */
   private $request;
   /**
    * @var \Application\Services\FileService
    */
   private $passwordService;
   private $response;

   public function __construct(Request $request, PasswordService $passwordService,
                               ResponseFactory $responseFactory){
      $this->request     = $request;
      $this->passwordService = $passwordService;
      $this->response    = $responseFactory->createResponse();
   }

   public function create(array $data){
      $this->passwordService->create($data);
      return $this->response->addNotifier(array('message' => 'Lösenordet har återställts och du kan nu logga in'));
   }
} 