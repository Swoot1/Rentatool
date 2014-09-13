<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 21/08/14
 * Time: 22:34
 */

namespace Application\Controllers;

use Application\ENFramework\Factories\DatabaseConnectionFactory;
use Application\ENFramework\Helpers\MySQLValueFormatter;
use Application\ENFramework\Helpers\ResponseFactory;
use Application\ENFramework\Helpers\SessionManager;
use Application\ENFramework\Models\DatabaseConnection;
use Application\ENFramework\Models\Request;
use Application\Mappers\RentalObjectMapper;
use Application\Services\PricePlanService;
use Application\Services\RentalObjectService;

class PricePlanController {
   /**
    * @var \Application\Services\RentalObjectService
    */
   private $request;
   /**
    * @var \Application\Services\PricePlanService
    */
   private $pricePlanService;
   private $response;

   public function __construct(Request $request, PricePlanService $pricePlanService,
                               ResponseFactory $responseFactory){
      $this->request             = $request;
      $this->pricePlanService = $pricePlanService;
      $this->response            = $responseFactory->createResponse();
   }

   public function create(array $data){
      $currentUser = SessionManager::getCurrentUser();
      $rentalObjectMapper = new RentalObjectMapper(new DatabaseConnection(new DatabaseConnectionFactory(), new MySQLValueFormatter()));
      $rentalObjectService = new RentalObjectService($rentalObjectMapper, $this->pricePlanService);
      $pricePlan = $this->pricePlanService->create($data, $currentUser, $rentalObjectService);
      return $this->response
         ->setStatusCode(201)
         ->setResponseData($pricePlan)
         ->addNotifier(array('message' => 'Prisplanen har skapats.'));
   }

   public function delete($id){
      $currentUser = SessionManager::getCurrentUser();
      $rentalObjectMapper = new RentalObjectMapper(new DatabaseConnection(new DatabaseConnectionFactory(), new MySQLValueFormatter()));
      $rentalObjectService = new RentalObjectService($rentalObjectMapper, $this->pricePlanService);
      $this->pricePlanService->delete($id, $currentUser, $rentalObjectService);
      return $this->response
         ->setStatusCode(204);
   }
} 