<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:20
 */

namespace Application\Controllers;

use Application\ENFramework\Models\Request;
use Application\ENFramework\Response\Factories\ResponseFactory;
use Application\Filters\UnavailableRentPeriodFilter;
use Application\Services\UnavailableRentPeriodService;

class UnavailableRentPeriodController{
   protected $request;
   protected $unavailableRentPeriodService;
   protected $response;

   public function __construct(Request $request, UnavailableRentPeriodService $unavailableRentPeriodsService, ResponseFactory $responseFactory){
      $this->request                      = $request;
      $this->unavailableRentPeriodService = $unavailableRentPeriodsService;
      $this->response                     = $responseFactory->createResponse();
   }

   public function index(){
      $GETParameters                   = $this->request->getGETParameters();
      $GETParameters['rentalObjectId'] = array_key_exists('rentalObjectId', $GETParameters) ? (int)$GETParameters['rentalObjectId'] : null;
      $unavailableRentPeriodFilter     = new UnavailableRentPeriodFilter($GETParameters);
      $unavailableRentPeriodCollection = $this->unavailableRentPeriodService->index($unavailableRentPeriodFilter);

      return $this->response->setResponseData($unavailableRentPeriodCollection);
   }
} 