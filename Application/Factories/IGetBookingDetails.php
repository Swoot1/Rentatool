<?php

namespace Application\Factories;

use Application\Models\RentalObject;
use Application\Models\RentPeriod;
use Application\Models\User;

/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 01/01/15
 * Time: 09:47
 */
interface IGetBookingDetails{
   public function getBookingDetails(RentPeriod $rentPeriod, User $rentalObjectOwner, RentalObject $rentalObject);
}