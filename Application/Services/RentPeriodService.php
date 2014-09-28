<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Application\Services;


use Application\Mappers\RentPeriodMapper;
use Application\Models\RentPeriod;
use Application\Models\User;

class RentPeriodService{
   private $rentPeriodMapper;
   private $rentPeriodValidationService;
   private $rentalObjectService;

   public function __construct(RentPeriodMapper $rentPeriodMapper,
                               RentPeriodValidationService $rentPeriodValidationService,
                               RentalObjectService $rentalObjectService){
      $this->rentPeriodMapper            = $rentPeriodMapper;
      $this->rentPeriodValidationService = $rentPeriodValidationService;
      $this->rentalObjectService         = $rentalObjectService;
   }

   public function create(array $data, User $currentUser){
      $rentPeriod = $this->getCalculatedPricePlan($data, $currentUser);
      $this->rentPeriodValidationService->checkIsValidRentPeriod($rentPeriod);
      $this->rentPeriodMapper->create($rentPeriod->getDBParameters());

      return $rentPeriod;
   }

   public function getCalculatedPricePlan(array $data, User $currentUser){
      $rentPeriod          = new RentPeriod(array_merge(array('renterId' => $currentUser->getId()), $data));
      $rentalObject = $this->rentalObjectService->read($rentPeriod->getRentalObjectId());
      $rentPeriod->setPricePerDay($rentalObject);

      return $rentPeriod;
   }
}