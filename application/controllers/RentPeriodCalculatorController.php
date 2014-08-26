<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 26/08/14
 * Time: 15:13
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Services\RentPeriodService;

class RentPeriodCalculatorController{

   private $request;
   /**
    * @var \Rentatool\Application\Services\RentPeriodService
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
      $rentPeriod  = $this->rentPeriodService->getCalculatedPricePlan($data, $currentUser);

      return $this->response
         ->setStatusCode(201)
         ->setResponseData($rentPeriod);
   }
} 