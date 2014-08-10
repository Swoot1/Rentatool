<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:50
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Notifier;
use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\Services\rentalObjectService;

class RentalObjectController{
   /**
    * @var \Rentatool\Application\Services\RentalObjectService
    */
   private $rentalObjectService;

   public function __construct(RentalObjectService $rentalObjectService){
      $this->rentalObjectService = $rentalObjectService;
   }

   /**
    * @return Response
    */
   public function index(){
      $rentalObjectService    = $this->rentalObjectService;
      $responseFactory        = new ResponseFactory();
      $response               = $responseFactory->createResponse();
      $rentalObjectCollection = $rentalObjectService->index();
      $response->setResponseData($rentalObjectCollection);

      return $response;
   }

   public function create(array $data){
      $rentalObjectService = $this->rentalObjectService;
      $currentUser         = SessionManager::getCurrentUser();
      $rentalObject        = $rentalObjectService->create($data, $currentUser);
      $responseFactory     = new ResponseFactory();
      $response            = $responseFactory->createResponse();
      $successNotifier = new Notifier(array('message' => 'Uthyrningsobjektet har skapats.'));
      $response->addNotifier($successNotifier);
      $response->setResponseData($rentalObject)->setStatusCode(201);

      return $response;
   }

   public function read($id){
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->read($id);
      $responseFactory     = new ResponseFactory();
      $response            = $responseFactory->createResponse();
      $response->setResponseData($rentalObject);

      return $response;
   }

   public function update($id, $requestData){
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->update($id, $requestData);
      $responseFactory     = new ResponseFactory();
      $response            = $responseFactory->createResponse();
      $successNotifier = new Notifier(array('message' => 'Uthyrningsobjektet har uppdaterats.'));
      $response->addNotifier($successNotifier);
      $response->setResponseData($rentalObject);

      return $response;
   }

   public function delete($id){
      $this->rentalObjectService->delete($id);
      $responseFactory = new ResponseFactory();
      $response        = $responseFactory->createResponse();
      $successNotifier = new Notifier(array('message' => 'Uthyrningsobjektet har tagits bort.'));
      $response->addNotifier($successNotifier);
      $response->setStatusCode(204);

      return $response;
   }
}