<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/12/14
 * Time: 18:21
 */

namespace Application\Controllers;


use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;
use Application\Services\RentalObjectService;

class InactivateRentalObjectController {
   private $rentalObjectService;
   private $response;
   private $sessionManager;

   public function __construct(RentalObjectService $rentalObjectService, ResponseFactory $responseFactory,
                               SessionManager $sessionManager){
      $this->rentalObjectService = $rentalObjectService;
      $this->response                 = $responseFactory->build();
      $this->sessionManager           = $sessionManager;
   }

   public function update($id){

      $this->rentalObjectService->inactivate($id, $this->sessionManager->getCurrentUser());

      return $this->response->addNotifier(array('message' => 'Uthyrningsobjektet har inaktiverats.'));
   }
} 