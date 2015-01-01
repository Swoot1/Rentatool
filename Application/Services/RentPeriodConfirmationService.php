<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 16:00
 */

namespace Application\Services;

use Application\Factories\IGetRentPeriodConfirmation;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class RentPeriodConfirmationService{
   private $rentPeriodService;
   private $userService;
   private $rentalObjectService;

   public function __construct(RentPeriodService $rentPeriodService, UserService $userService, RentalObjectService $rentalObjectService){
      $this->rentPeriodService   = $rentPeriodService;
      $this->userService         = $userService;
      $this->rentalObjectService = $rentalObjectService;

      return $this;
   }

   public function read($rentPeriodId, User $currentUser, IGetRentPeriodConfirmation $rentPeriodConfirmationFactory){
      $rentPeriod = $this->rentPeriodService->read($rentPeriodId);
      $this->checkCurrentUserIsRenter($currentUser, $rentPeriod);

      $rentalObject      = $this->rentalObjectService->read($rentPeriod->getRentalObjectId());
      $rentalObjectOwner = $this->userService->read($rentalObject->getUserId());

      return $rentPeriodConfirmationFactory->getRentPeriodConfirmation($rentPeriod, $rentalObjectOwner, $rentalObject);
   }

   /**
    * Validates that the user is allowed to read the rent period confirmation.
    * @param $renter
    * @param $rentPeriod
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkCurrentUserIsRenter($renter, $rentPeriod){
      if ($renter->getId() !== $rentPeriod->getRenterId()){
         throw new ApplicationException('Du har inte rättighet att visa den här bokningsbekräftelsen.');
      }

      return true;
   }
} 
