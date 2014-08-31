<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 20:54
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\Mappers\PricePlanMapper;
use Rentatool\Application\Models\PricePlan;
use Rentatool\Application\Models\RentalObject;

class PricePlanService{
   /**
    * @var \Rentatool\Application\Mappers\PricePlanMapper
    */
   protected $pricePlanMapper;

   public function __construct(PricePlanMapper $pricePlanMapper){
      $this->pricePlanMapper = $pricePlanMapper;
   }

   /**
    * @param array $data
    * @return PricePlan
    */
   public function create(array $data){
      $pricePlan = new PricePlan($data);
      $this->checkIsUniquePricePlan($pricePlan);
      $data = $this->pricePlanMapper->create($pricePlan->getDBParameters());
      return new PricePlan($data);
   }

   /**
    * Checks that there's not an existing priceplan with the same time unit.
    * @param PricePlan $pricePlan
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkIsUniquePricePlan(PricePlan $pricePlan){
      $isUniquePricePlan = $this->pricePlanMapper->isUniquePlan(
                                               $pricePlan->getRentalObjectId(),
                                               $pricePlan->getTimeUnitId()
      );

      if ($isUniquePricePlan === false){
         throw new ApplicationException('Det finns redan ett pris för vald tidsenhet.');
      }

      return true;
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
    * @return PricePlanCollection
    */
   public function createFromCollection(PricePlanCollection $pricePlanCollection, RentalObject $rentalObject){

      $pricePlanCollectionData = $pricePlanCollection->getDBParameters();
      $result                  = array();

      foreach ($pricePlanCollectionData as $pricePlanData){
         $pricePlanData['rentalObjectId'] = $rentalObject->getId();
         unset($pricePlanData['id']);
         $result[]                        = $this->create($pricePlanData);
      }

      return new PricePlanCollection($result);
   }

   /**
    * @param $id
    * @return $this
    */
   public function delete($id){
      $this->pricePlanMapper->delete($id);

      return $this;
   }
} 