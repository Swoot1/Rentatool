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
   private $mailFactory;

   public function __construct(ResetPasswordService $resetPasswordService, ResponseFactory $responseFactory, MailFactory $mailFactory){
      $this->resetPasswordService = $resetPasswordService;
      $this->response             = $responseFactory->build();
      $this->mailFactory          = $mailFactory;
   }

   public function create(array $data){

      $this->resetPasswordService->create($data, $this->mailFactory);

      return $this->response->addNotifier(
                            array(
                               'message' => 'Ett återställningsmail har skickats till din e-postadress.')
      );
   }
}