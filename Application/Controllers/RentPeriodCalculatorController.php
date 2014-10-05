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

   public function __construct(RentPeriodService $rentPeriodService, ResponseFactory $responseFactory){
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->build();
   }

   public function create(array $data){
      $currentUser = SessionManager::getCurrentUser();
      $rentPeriod  = $this->rentPeriodService->getCalculatedPricePlan($data, $currentUser);

      return $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod);
   }
} 