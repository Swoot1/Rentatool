<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 16:00
 */

namespace Application\Services;

use Application\Collections\BookingCollection;
use Application\Factories\IGetBookingDetails;
use Application\Mappers\BookingMapper;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class BookingService{
   private $rentPeriodService;
   private $userService;
   private $rentalObjectService;
   private $bookingMapper;

   public function __construct(RentPeriodService $rentPeriodService, UserService $userService, RentalObjectService $rentalObjectService, BookingMapper $bookingMapper){
      $this->rentPeriodService   = $rentPeriodService;
      $this->userService         = $userService;
      $this->rentalObjectService = $rentalObjectService;
      $this->bookingMapper       = $bookingMapper;

      return $this;
   }

   public function read($rentPeriodId, User $currentUser, IGetBookingDetails $getBookingDetailsFactory){
      $rentPeriod = $this->rentPeriodService->read($rentPeriodId);
      $this->checkCurrentUserIsRenter($currentUser, $rentPeriod);

      $rentalObject      = $this->rentalObjectService->read($rentPeriod->getRentalObjectId());
      $rentalObjectOwner = $this->userService->read($rentalObject->getUserId());

      return $getBookingDetailsFactory->getBookingDetails($rentPeriod, $rentalObjectOwner, $rentalObject);
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

   public function index(User $currentUser){
      $bookingDataList = $this->bookingMapper->index($currentUser);

      return new BookingCollection($bookingDataList);
   }
} 
