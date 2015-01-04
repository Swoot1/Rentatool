<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/01/15
 * Time: 09:45
 */

namespace Application\Controllers;


use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;
use Application\Services\RentPeriodService;

class CancelRentPeriodController{

   private $rentPeriodService;
   private $response;
   private $sessionManager;

   public function __construct(RentPeriodService $rentPeriodService, ResponseFactory $responseFactory,
                               SessionManager $sessionManager){
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->build();
      $this->sessionManager    = $sessionManager;
   }


   public function read($id){

      $rentPeriod = $this->rentPeriodService->cancelRentPeriod($id, $this->sessionManager->getCurrentUser());

      return $this->response
         ->addNotifier(array('message' => 'Bokningen har blivit avbokad.'))
         ->setResponseData($rentPeriod);
   }
} 
