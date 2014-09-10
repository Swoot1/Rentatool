<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:20
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Filters\UnavailableRentPeriodFilter;
use Rentatool\Application\Services\UnavailableRentPeriodService;

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