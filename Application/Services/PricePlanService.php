<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 20:54
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\Mappers\PricePlanMapper;
use Rentatool\Application\Models\PricePlan;
use Rentatool\Application\Models\RentalObject;
use Rentatool\Application\Models\User;

class PricePlanService{
   /**
    * @var \Rentatool\Application\Mappers\PricePlanMapper
    */
   protected $pricePlanMapper;
   /**
    * @var PricePlanValidationService
    */
   protected $pricePlanValidationService;

   public function __construct(PricePlanMapper $pricePlanMapper, PricePlanValidationService $pricePlanValidationService){
      $this->pricePlanMapper     = $pricePlanMapper;
      $this->pricePlanValidationService = $pricePlanValidationService;
   }

   /**
    * @param array $data
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return PricePlan
    */
   public function create(array $data, User $currentUser, RentalObjectService $rentalObjectService){

      $pricePlan = new PricePlan($data);
      $this->pricePlanValidationService->checkIsOwnerOfRentalObject($pricePlan->getRentalObjectId(), $currentUser, $rentalObjectService);
      $this->pricePlanValidationService->checkIsUniquePricePlan($pricePlan);
      $data = $this->pricePlanMapper->create($pricePlan->getDBParameters());

      return new PricePlan($data);
   }

   /**
    * @param $rentalObjectId
    * @return PricePlanCollection
    */
   public function readCollectionFromRentalObjectId($rentalObjectId){
      $rentalObjectCollectionData = $this->pricePlanMapper->readCollectionFromRentalObjectId($rentalObjectId);

      return new PricePlanCollection($rentalObjectCollectionData);
   }

   /**
    * @param PricePlanCollection $pricePlanCollection
    * @param RentalObject $rentalObject
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return PricePlanCollection
    */
   public function createFromCollection(PricePlanCollection $pricePlanCollection, RentalObject $rentalObject, User $currentUser, RentalObjectService $rentalObjectService){

      $pricePlanCollectionData = $pricePlanCollection->getDBParameters();
      $result                  = array();

      foreach ($pricePlanCollectionData as $pricePlanData){
         $pricePlanData['rentalObjectId'] = $rentalObject->getId();
         unset($pricePlanData['id']);
         $result[] = $this->create($pricePlanData, $currentUser, $rentalObjectService);
      }

      return new PricePlanCollection($result);
   }

   /**
    * @param $id
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return $this
    */
   public function delete($id, User $currentUser, RentalObjectService $rentalObjectService){
      $this->pricePlanValidationService->checkIsOwnerOfRentalObject($id, $currentUser, $rentalObjectService);
      $this->pricePlanMapper->delete($id);

      return $this;
   }
}