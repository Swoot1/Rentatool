<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 26/08/14
 * Time: 15:13
 */

namespace Application\Controllers;

use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\RentPeriodService;

class RentPeriodCalculatorController{

   /**
    * @var \Application\Services\RentPeriodService
    */
   private $rentPeriodService;
   private $response;
   private $sessionManager;

   public function __construct(RentPeriodService $rentPeriodService, ResponseFactory $responseFactory, SessionManager $sessionManager){
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->build();
      $this->sessionManager    = $sessionManager;
   }

   public function create(array $data){

      $currentUser = $this->sessionManager->getCurrentUser();
      $rentPeriod  = $this->rentPeriodService->getCalculatedPricePlan($data, $currentUser);

      $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod);

      return $this->response;
   }
} 