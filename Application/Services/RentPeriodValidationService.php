<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 22:07
 */

namespace Application\Services;


use Application\Models\IGetRenterId;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\Mappers\RentPeriodValidationMapper;
use Application\Models\RentPeriod;
use Application\PHPFramework\Interfaces\IToArray;

class RentPeriodValidationService{

   private $rentPeriodValidationMapper;

   public function __construct(RentPeriodValidationMapper $rentPeriodValidationMapper){
      $this->rentPeriodValidationMapper = $rentPeriodValidationMapper;
   }

   public function checkIsValidRentPeriod(RentPeriod $rentPeriod){
      $isAvailableRentPeriod = $this->rentPeriodValidationMapper->isAvailableRentPeriod(
                                                                array(
                                                                   'fromDate'       => $rentPeriod->getFromDate(),
                                                                   'toDate'         => $rentPeriod->getToDate(),
                                                                   'rentalObjectId' => $rentPeriod->getRentalObjectId()
                                                                )
      );

      if ($isAvailableRentPeriod === false){
         throw new ApplicationException('Objektet är inte tillgängligt under vald period.');
      }

      return true;
   }

   /**
    * Validates that the user is allowed to read the rent period confirmation.
    * @param User $renter
    * @param IGetRenterId $rentPeriod
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   public function checkCurrentUserIsRenter(User $renter, IGetRenterId $rentPeriod){
      if ($renter->getId() !== $rentPeriod->getRenterId()){
         throw new ApplicationException('Du har inte rättighet att visa den här bokningsbekräftelsen.');
      }

      return true;
   }
} 