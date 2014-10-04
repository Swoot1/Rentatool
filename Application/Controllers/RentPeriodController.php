<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:38
 */

namespace Application\Controllers;

use Application\ENFramework\SessionManager;
use Application\ENFramework\Request\Request;
use Application\ENFramework\Response\Factories\ResponseFactory;
use Application\Services\RentPeriodService;

class RentPeriodController{

   private $request;
   /**
    * @var \Application\Services\RentPeriodService
    */
   private $rentPeriodService;
   private $response;

   public function __construct(Request $request, RentPeriodService $rentPeriodService, ResponseFactory $responseFactory){
      $this->request           = $request;
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->createResponse();
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