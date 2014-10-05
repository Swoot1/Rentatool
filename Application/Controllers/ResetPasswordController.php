<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:20
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Factories\MailFactory;
use Application\Services\ResetPasswordService;

class ResetPasswordController{
   /**
    * @var \Application\Services\RentPeriodService
    */
   private $resetPasswordService;
   private $response;

   public function __construct(ResetPasswordService $resetPasswordService, ResponseFactory $responseFactory){
      $this->resetPasswordService = $resetPasswordService;
      $this->response             = $responseFactory->build();
   }

   public function create(array $data){
      $mailFactory = new MailFactory(new \PHPMailer());
      $this->resetPasswordService->create($data, $mailFactory);

      return $this->response->addNotifier(array('message' => 'Ett återställningsmail har skickats till din e-postadress.'));
   }
}