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
use Application\Services\BookingService;

class BookingController{

   private $bookingService;
   private $response;
   private $sessionManager;


   public function __construct(BookingService $bookingService, ResponseFactory $responseFactory, SessionManager $sessionManager){
      $this->bookingService = $bookingService;
      $this->response       = $responseFactory->build();
      $this->sessionManager = $sessionManager;
   }

   public function read($rentPeriodId){
      $rentPeriodConfirmationFactory = new RentPeriodConfirmationFactory();
      $rentPeriodConfirmation        = $this->bookingService->read($rentPeriodId, $this->sessionManager->getCurrentUser(), $rentPeriodConfirmationFactory);

      return $this->response->setResponseData($rentPeriodConfirmation);
   }

   public function index(){

      $bookingCollection = $this->bookingService->index($this->sessionManager->getCurrentUser());

      return $this->response->setResponseData($bookingCollection);
   }
} 
