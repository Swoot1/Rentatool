<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 21/08/14
 * Time: 22:34
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Factories\DatabaseConnectionFactory;
use Rentatool\Application\ENFramework\Helpers\MySQLValueFormatter;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\ENFramework\Models\DatabaseConnection;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Services\PricePlanService;
use Rentatool\Application\Services\RentalObjectService;

class PricePlanController {
   /**
    * @var \Rentatool\Application\Services\RentalObjectService
    */
   private $request;
   /**
    * @var \Rentatool\Application\Services\PricePlanService
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