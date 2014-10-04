<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:50
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Controllers;

use Application\ENFramework\SessionManager;
use Application\ENFramework\Models\Request;
use Application\ENFramework\Response\Factories\ResponseFactory;
use Application\Filters\RentalObjectFilter;
use Application\Services\rentalObjectService;

class RentalObjectController{
   /**
    * @var \Application\Services\RentalObjectService
    */
   private $request;
   private $rentalObjectService;
   private $response;

   public function __construct(Request $request, RentalObjectService $rentalObjectService, ResponseFactory $responseFactory){
      $this->request             = $request;
      $this->rentalObjectService = $rentalObjectService;
      $this->response            = $responseFactory->createResponse();
   }

   /**
    * @return \Application\ENFramework\Response\Response
    */
   public function index(){
      $GETParameters          = $this->request->getGETParameters();
      $rentalObjectFilter     = new RentalObjectFilter($GETParameters);
      $rentalObjectCollection = $this->rentalObjectService->index($rentalObjectFilter);
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
      $currentUser       = SessionManager::getCurrentUser();
      $requestData['id'] = $id;
      $rentalObject      = $this->rentalObjectService->update($requestData, $currentUser);

      $this->response->setResponseData($rentalObject);
      $this->response->addNotifier(['message' => 'Uthyrningsobjektet har uppdaterats.']);

      return $this->response;
   }

   public function delete($id){
      $currentUser = SessionManager::getCurrentUser();
      $this->rentalObjectService->delete($id, $currentUser);
      $this->response->setStatusCode(204);

      return $this->response;
   }
}