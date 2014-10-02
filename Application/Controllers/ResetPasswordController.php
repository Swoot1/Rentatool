<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:20
 */

namespace Application\Controllers;


use Application\ENFramework\Helpers\ResponseFactory;
use Application\ENFramework\Helpers\SessionManager;
use Application\ENFramework\Models\Request;
use Application\Factories\MailFactory;
use Application\Services\ResetPasswordService;

class ResetPasswordController{
   /**
    * @var \Application\Services\RentPeriodService
    */
   private $resetPasswordService;
   private $response;

   public function __construct(Request $request, ResetPasswordService $resetPasswordService, ResponseFactory $responseFactory){
      $this->request              = $request;
      $this->resetPasswordService = $resetPasswordService;
      $this->response             = $responseFactory->createResponse();
   }

   public function create(array $data){
      $mailFactory = new MailFactory();
      $this->resetPasswordService->create($data, $mailFactory);
      return $this->response->addNotifier(array('message' => 'Ett återställningsmail har skickats till din e-postadress.'));
   }
}