<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:38
 */

namespace Application\Controllers;

use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\RentPeriodService;

class RentPeriodController{

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
      $rentPeriod  = $this->rentPeriodService->create($data, $currentUser);

      $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod)
         ->addNotifier(array('message' => 'Objektet har hyrts wohoo!'));

      return $this->response;
   }

   public function getCalculatedRentPeriod(array $data){
      $currentUser = $this->sessionManager->getCurrentUser();
      $rentPeriod  = $this->rentPeriodService->getCalculatedPricePlan($data, $currentUser);

      $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod);

      return $this->response;
   }

   public function index(){
      $currentUser = $this->sessionManager->getCurrentUser();
      $rentPeriodCollection = $this->rentPeriodService->index($currentUser);

      $this->response
         ->setResponseData($rentPeriodCollection);

      return $this->response;
   }
} 