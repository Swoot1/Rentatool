<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 15:59
 */

namespace Application\Controllers;


use Application\Factories\RentPeriodConfirmationFactory;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;
use Application\Services\RentPeriodConfirmationService;

class RentPeriodConfirmationController{

   private $rentPeriodConfirmationService;
   private $response;
   private $sessionManager;


   public function __construct(RentPeriodConfirmationService $rentPeriodConfirmationService, ResponseFactory $responseFactory, SessionManager $sessionManager){
      $this->rentPeriodConfirmationService = $rentPeriodConfirmationService;
      $this->response                      = $responseFactory->build();
      $this->sessionManager                = $sessionManager;
   }

   public function read($rentPeriodId){
      $rentPeriodConfirmationFactory = new RentPeriodConfirmationFactory();
      $rentPeriodConfirmation        = $this->rentPeriodConfirmationService->read($rentPeriodId, $this->sessionManager->getCurrentUser(), $rentPeriodConfirmationFactory);

      return $this->response->setResponseData($rentPeriodConfirmation);
   }
} 
