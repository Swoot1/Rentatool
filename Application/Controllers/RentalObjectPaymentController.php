<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 06/11/14
 * Time: 17:24
 */

namespace Application\Controllers;


use Application\PaymentResources\StripePayment;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;

class RentalObjectPaymentController{
   private $response;
   private $sessionManager;


   public function __construct(ResponseFactory $responseFactory, SessionManager $sessionManager){
      $this->response       = $responseFactory->build();
      $this->sessionManager = $sessionManager;
   }

   public function create(array $data){
      $stripePayment = new StripePayment();
      $stripePayment->pay($data);
   }
} 