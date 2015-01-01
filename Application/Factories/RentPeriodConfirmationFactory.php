<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 16:28
 */

namespace Application\Factories;


use Application\Models\RentalObject;
use Application\Models\RentPeriod;
use Application\Models\RentPeriodConfirmation;
use Application\Models\User;

class RentPeriodConfirmationFactory implements IGetRentPeriodConfirmation{

   public function getRentPeriodConfirmation(RentPeriod $rentPeriod, User $rentalObjectOwner, RentalObject $rentalObject){
      $data = array();
      $data['fromDate']              = $rentPeriod->getFromDate();
      $data['toDate']                = $rentPeriod->getToDate();
      $data['rentalObjectOwnerName'] = $rentalObjectOwner->getUsername();
      $data['price']                 = $rentPeriod->getPrice();
      $data['rentalObjectName']      = $rentalObject->getName();

      return new RentPeriodConfirmation($data);
   }
} 
