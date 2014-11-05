<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/11/14
 * Time: 17:10
 */

namespace Application\Controllers;

use Application\Factories\MailFactory;
use Application\PHPFramework\Configurations\MailConfiguration;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\PHPFramework\SessionManager;
use Application\Services\ConfirmRentPeriodService;

class ConfirmRentPeriodController{

   private $confirmRentPeriodService;
   private $response;
   private $sessionManager;

   public function __construct(ConfirmRentPeriodService $confirmRentPeriodService, ResponseFactory $responseFactory,
                               SessionManager $sessionManager){
      $this->confirmRentPeriodService = $confirmRentPeriodService;
      $this->response                 = $responseFactory->build();
      $this->sessionManager           = $sessionManager;
   }

   public function update($id, array $data){

      $this->confirmRentPeriodService->confirmRentPeriod($id, $this->sessionManager->getCurrentUser());
      $emailContent = array_key_exists('emailContent', $data) ? $data['emailContent'] : false;
      $this->confirmRentPeriodService->sendRentPeriodConfirmation($id, $emailContent, new MailFactory(new \PHPMailer(), new MailConfiguration()));

      return $this->response->addNotifier(array('message' => 'Uthyrningsperioden har bekräftats och ett meddelande har skickats.'));
   }
} 