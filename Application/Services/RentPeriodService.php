<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Mappers\RentPeriodMapper;
use Rentatool\Application\Models\RentPeriod;
use Rentatool\Application\Models\RentPeriodPriceCalculator;
use Rentatool\Application\Models\User;

class RentPeriodService{
   private $rentPeriodMapper;
   private $rentPeriodValidationService;
   private $pricePlanService;

   public function __construct(RentPeriodMapper $rentPeriodMapper,
                               RentPeriodValidationService $rentPeriodValidationService,
                               PricePlanService $pricePlanService){
      $this->rentPeriodMapper            = $rentPeriodMapper;
      $this->rentPeriodValidationService = $rentPeriodValidationService;
      $this->pricePlanService            = $pricePlanService;
   }

   public function create(array $data, User $currentUser){
      $rentPeriod = new RentPeriod(array_merge(array('renterId' => $currentUser->getId()), $data), new RentPeriodPriceCalculator());
      $this->rentPeriodValidationService->checkIsValidRentPeriod($rentPeriod);
      $this->rentPeriodMapper->create($rentPeriod->getDBParameters());

      return $rentPeriod;
   }

   public function getCalculatedPricePlan(array $data, User $currentUser){
      $rentPeriod = new RentPeriod(array_merge(array('renterId' => $currentUser->getId()), $data), new RentPeriodPriceCalculator());
      $pricePlanCollection = $this->pricePlanService->readCollectionFromRentalObjectId($rentPeriod->getRentalObjectId());
      $rentPeriod->setPricePlanCollection($pricePlanCollection);
      return $rentPeriod;
   }
}