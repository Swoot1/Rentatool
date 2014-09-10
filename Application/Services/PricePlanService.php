<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 20:54
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
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
      $this->pricePlanMapper            = $pricePlanMapper;
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
      $this->pricePlanValidationService->validateCreate($pricePlan, $currentUser, $rentalObjectService);
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

      $pricePlanCollection->setRentalObjectId($rentalObject);
      $pricePlanCollectionData = $pricePlanCollection->getDBParameters();
      $pricePlanCollection->validateNumberOfPricePlans();

      foreach ($pricePlanCollectionData as $key => $pricePlanData){
         unset($pricePlanData['id']);
         $pricePlanCollectionData[$key] = $this->create($pricePlanData, $currentUser, $rentalObjectService);
      }

      return new PricePlanCollection($pricePlanCollectionData);
   }

   /**
    * @param $id
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return $this
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   public function delete($id, User $currentUser, RentalObjectService $rentalObjectService){
      $pricePlanData = $this->pricePlanMapper->read($id);

      if ($pricePlanData === null){
         throw new NotFoundException('Kunde inte hitta prisplanen.');
      }

      $this->pricePlanValidationService->validateDelete(new PricePlan($pricePlanData), $currentUser, $rentalObjectService);
      $this->pricePlanMapper->delete($id);

      return $this;
   }
}