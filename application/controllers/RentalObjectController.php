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
      $rentalObjectService    = $this->rentalObjectService;
      $rentalObjectCollection = $rentalObjectService->index();
      $this->response->setResponseData($rentalObjectCollection);

      return $this->response;
   }

   public function create(array $data){
      $rentalObjectService = $this->rentalObjectService;
      $currentUser         = SessionManager::getCurrentUser();
      $rentalObject        = $rentalObjectService->create($data, $currentUser);
      $successNotifier     = new Notifier(array('message' => 'Uthyrningsobjektet har skapats.'));
      $this->response->addNotifier($successNotifier);
      $this->response->setResponseData($rentalObject)->setStatusCode(201);

      return $this->response;
   }

   public function read($id){
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->read($id);
      $this->response->setResponseData($rentalObject);

      return $this->response;
   }

   public function update($id, $requestData){
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->update($id, $requestData);
      $successNotifier     = new Notifier(array('message' => 'Uthyrningsobjektet har uppdaterats.'));
      $this->response->addNotifier($successNotifier);
      $this->response->setResponseData($rentalObject);

      return $this->response;
   }

   public function delete($id){
      $this->rentalObjectService->delete($id);
      $successNotifier = new Notifier(array('message' => 'Uthyrningsobjektet har tagits bort.'));
      $this->response->addNotifier($successNotifier);
      $this->response->setStatusCode(204);

      return $this->response;
   }
}