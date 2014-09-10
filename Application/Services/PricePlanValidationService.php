<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/09/14
 * Time: 20:21
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Mappers\PricePlanMapper;
use Rentatool\Application\Models\PricePlan;
use Rentatool\Application\Models\User;

class PricePlanValidationService {

   private $pricePlanMapper;

   public function __construct(PricePlanMapper $pricePlanMapper){
      $this->pricePlanMapper = $pricePlanMapper;
   }

   /**
    * @param PricePlan $pricePlan
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return $this
    */
   public function validateCreate(PricePlan $pricePlan, User $currentUser, RentalObjectService $rentalObjectService){
      $this->checkIsOwnerOfRentalObject($pricePlan->getRentalObjectId(), $currentUser, $rentalObjectService);
      $this->checkIsUniquePricePlan($pricePlan);

      return $this;
   }

   public function validateDelete(PricePlan $pricePlan, User $currentUser, RentalObjectService $rentalObjectService){
      $this->checkIsOwnerOfRentalObject($pricePlan, $currentUser, $rentalObjectService);
      $this->validateNumberOfPricePlans($pricePlan);
      return $this;
   }

   /**
    * @param PricePlan $pricePlan
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkIsOwnerOfRentalObject(PricePlan $pricePlan, User $currentUser, RentalObjectService $rentalObjectService){
      $rentalObject = $rentalObjectService->read($pricePlan->getRentalObjectId());

      if ($rentalObject === null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjektet.');
      }

      if ($rentalObject->isOwner($currentUser) === false){
         throw new ApplicationException('Kan inte uppdatera objekt som du inte är ägare av.');
      }

      return true;
   }

   private function validateNumberOfPricePlans(PricePlan $pricePlan){
      $numberOfPricePlans = $this->pricePlanMapper->getNumberOfPricePlans($pricePlan->getRentalObjectId());
      $notAllowedToRemovePricePlan = $numberOfPricePlans < 2;

      if($notAllowedToRemovePricePlan){
         throw new ApplicationException('Kan inte ta bort prisplanen. Ett uthyrningsobjekt måste ha minst en prisplan');
      }

      return true;
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
} 