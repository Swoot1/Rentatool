<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 22:07
 */

namespace Application\Services;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\Mappers\RentPeriodValidationMapper;
use Application\Models\RentPeriod;

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
} 