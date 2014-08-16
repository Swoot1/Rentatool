<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:38
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Services\RentPeriodService;

class RentPeriodController{

   private $request;
   private $rentPeriodService;
   private $response;

   public function __construct(Request $request, RentPeriodService $rentPeriodService, ResponseFactory $responseFactory){
      $this->request           = $request;
      $this->rentPeriodService = $rentPeriodService;
      $this->response          = $responseFactory->createResponse();
   }

   public function create(array $data){
      $currentUser = SessionManager::getCurrentUser();
      $this->rentPeriodService->create($data, $currentUser);

      return $this->response
         ->setStatusCode(201)
         ->addNotifier(array('message' => 'Objektet har hyrts wohoo!'));
   }
} 