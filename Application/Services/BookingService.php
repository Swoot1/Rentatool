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
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;

class BookingService{
   private $bookingMapper;
   private $rentPeriodValidationService;

   public function __construct(BookingMapper $bookingMapper, RentPeriodValidationService $rentPeriodValidationService){
      $this->bookingMapper               = $bookingMapper;
      $this->rentPeriodValidationService = $rentPeriodValidationService;

      return $this;
   }

   public function read($rentPeriodId, User $currentUser){

      $rentPeriodData = $this->bookingMapper->read($rentPeriodId);

      if ($rentPeriodData === null){
         throw new NotFoundException('Kunde inte hitta bokningsdetaljer.');
      }

      $booking = new Booking($rentPeriodData);
      $this->rentPeriodValidationService->checkCurrentUserIsRenter($currentUser, $booking);

      return $booking;
   }

   public function index(User $currentUser){
      $bookingDataList = $this->bookingMapper->index($currentUser);

      return new BookingCollection($bookingDataList);
   }
} 
