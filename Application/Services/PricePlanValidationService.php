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
    * @param $rentalObjectId
    * @param User $currentUser
    * @param RentalObjectService $rentalObjectService
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   public function checkIsOwnerOfRentalObject($rentalObjectId, User $currentUser, RentalObjectService $rentalObjectService){
      $rentalObject = $rentalObjectService->read($rentalObjectId);

      if ($rentalObject === null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjektet.');
      }

      if ($rentalObject->isOwner($currentUser) === false){
         throw new ApplicationException('Kan inte uppdatera objekt som du inte är ägare av.');
      }

      return true;
   }

   /**
    * Checks that there's not an existing priceplan with the same time unit.
    * @param PricePlan $pricePlan
    * @return bool
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   public function checkIsUniquePricePlan(PricePlan $pricePlan){
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