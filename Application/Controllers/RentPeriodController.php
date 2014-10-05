<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:38
 */

namespace Application\Controllers;

use Application\PHPFramework\SessionManager;
use Application\PHPFramework\Request\Request;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\RentPeriodService;

class RentPeriodController{

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
      $this->rentPeriodService->create($data, $currentUser);

      return $this->response
         ->setStatusCode(201)
         ->addNotifier(array('message' => 'Objektet har hyrts wohoo!'));
   }

   public function getCalculatedRentPeriod(array $data){
      $currentUser = SessionManager::getCurrentUser();
      $rentPeriod  = $this->rentPeriodService->getCalculatedPricePlan($data, $currentUser);

      return $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod);
   }
} 