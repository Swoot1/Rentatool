<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/11/14
 * Time: 17:10
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;
use Application\Services\RentPeriodService;

class ConfirmRentPeriodController{

   private $rentPeriodService;
   private $response;
   private $sessionManager;

   public function __construct(RentPeriodService $rentPeriodService, ResponseFactory $responseFactory,
                               SessionManager $sessionManager){
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->build();
      $this->sessionManager    = $sessionManager;
   }

   public function update($id, array $data){

      $this->rentPeriodService->confirmRentPeriod($id, $this->sessionManager->getCurrentUser());
      // TODO
      // $this->rentPeriodService->sendRentPeriodConfirmation($data);

      return $this->response;
   }
} 