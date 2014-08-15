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
   private $response;

   public function __construct(RentalObjectService $rentalObjectService, ResponseFactory $responseFactory){
      $this->rentalObjectService = $rentalObjectService;
      $this->response            = $responseFactory->createResponse();
   }

   /**
    * @return Response
    */
   public function index(){
      $rentalObjectCollection = $this->rentalObjectService->index();
      $this->response->setResponseData($rentalObjectCollection);

      return $this->response;
   }

   public function create(array $data){
      $currentUser  = SessionManager::getCurrentUser();
      $rentalObject = $this->rentalObjectService->create($data, $currentUser);
      $this->response->setResponseData($rentalObject)->setStatusCode(201);
      $this->response->addNotifier(['message' => 'Uthyrningsobjektet har skapats.']);

      return $this->response;
   }

   public function read($id){
      $rentalObject = $this->rentalObjectService->read($id);
      $this->response->setResponseData($rentalObject);

      return $this->response;
   }

   public function update($id, $requestData){
      $rentalObject = $this->rentalObjectService->update($id, $requestData);

      $this->response->setResponseData($rentalObject);
      $this->response->addNotifier(['message' => 'Uthyrningsobjektet har uppdaterats.']);

      return $this->response;
   }

   public function delete($id){
      $this->rentalObjectService->delete($id);

      $this->response->addNotifier(['message' => 'Uthyrningsobjektet har tagits bort.']);
      $this->response->setStatusCode(204);

      return $this->response;
   }
}