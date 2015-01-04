<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 16:00
 */

namespace Application\Services;

use Application\Collections\BookingCollection;
use Application\Mappers\BookingMapper;
use Application\Models\Booking;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;

class BookingService{
   private $bookingMapper;

   public function __construct(BookingMapper $bookingMapper){
      $this->bookingMapper       = $bookingMapper;

      return $this;
   }

   public function read($rentPeriodId, User $currentUser){

      $rentPeriodData = $this->bookingMapper->read($rentPeriodId);

      if($rentPeriodData === null){
         throw new NotFoundException('Kunde inte hitta bokningsdetaljer.');
      }

      $booking = new Booking($rentPeriodData);
      $this->checkCurrentUserIsRenter($currentUser, $booking);

      return $booking;
   }

   /**
    * Validates that the user is allowed to read the rent period confirmation.
    * @param User $renter
    * @param Booking $booking
    * @return bool
    * @throws \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    */
   private function checkCurrentUserIsRenter(User $renter, Booking $booking){
      if ($renter->getId() !== $booking->getRenterId()){
         throw new ApplicationException('Du har inte rättighet att visa den här bokningsbekräftelsen.');
      }

      return true;
   }

   public function index(User $currentUser){
      $bookingDataList = $this->bookingMapper->index($currentUser);

      return new BookingCollection($bookingDataList);
   }
} 
