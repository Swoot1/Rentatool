<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 15:04
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Services\TimeUnitService;

class TimeUnitController {
   public function __construct(Request $request, TimeUnitService $timeUnitService, ResponseFactory $responseFactory){
      $this->request = $request;
      $this->timeUnitService = $timeUnitService;
      $this->response = $responseFactory->createResponse();
   }

   public function create(array $data){
      $timeUnit = $this->timeUnitService->create($data);
      return $this->response
         ->setStatusCode(201)
         ->addNotifier(array('message' => 'Tidsenheten har skapats.'))
         ->setResponseData($timeUnit);
   }

   public function read($id){
      $timeUnit = $this->timeUnitService->read($id);
      return $this->response
         ->setResponseData($timeUnit);
   }

   public function index(){
      $timeUnitCollection = $this->timeUnitService->index();
      return $this->response->setResponseData($timeUnitCollection);
   }

   public function update($id, array $data){
      $timeUnit = $this->timeUnitService->update($id, $data);
      return $this->response
         ->addNotifier(array('message' => 'Tidsenheten har uppdaterats.'))
         ->setResponseData($timeUnit);
   }

   public function delete($id){
      $this->timeUnitService->delete($id);
      return $this->response;
   }
} 