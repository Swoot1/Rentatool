<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 21/08/14
 * Time: 22:34
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Services\PricePlanService;

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
      $pricePlan = $this->pricePlanService->create($data);
      return $this->response
         ->setStatusCode(201)
         ->setResponseData($pricePlan)
         ->addNotifier(array('message' => 'Prisplanen har skapats.'));
   }

   public function delete($id){
      $this->pricePlanService->delete($id);
      return $this->response
         ->setStatusCode(204);
   }
} 