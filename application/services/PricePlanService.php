<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 20:54
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Collections\PricePlanCollection;
use Rentatool\Application\Collections\RentalObjectCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Mappers\PricePlanMapper;
use Rentatool\Application\Models\PricePlan;

class PricePlanService{
   /**
    * @var \Rentatool\Application\Mappers\PricePlanMapper
    */
   protected $pricePlanMapper;

   public function __construct(PricePlanMapper $pricePlanMapper){
      $this->pricePlanMapper = $pricePlanMapper;
   }

   public function create(array $data){
      $pricePlan = new PricePlan($data);
      $this->checkIsUniquePricePlan($pricePlan);
      $data = $this->pricePlanMapper->create($pricePlan->getDBParameters());

      return new PricePlan($data);
   }

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

   public function readCollectionFromRentalObjectId($rentalObjectId){
      $rentalObjectCollectionData = $this->pricePlanMapper->readCollectionFromRentalObjectId($rentalObjectId);

      return new PricePlanCollection($rentalObjectCollectionData);
   }

   public function createFromCollection(PricePlanCollection $pricePlanCollection, $rentalObjectId){

      $pricePlanCollectionData = $pricePlanCollection->getDBParameters();
      $result                  = array();

      foreach ($pricePlanCollectionData as $pricePlanData){
         $pricePlanData['rentalObjectId'] = $rentalObjectId;
         unset($pricePlanData['id']);
         $result[]                        = $this->create($pricePlanData);
      }

      return new PricePlanCollection($result);
   }

   public function delete($id){
      $this->pricePlanMapper->delete($id);

      return $this;
   }
} 