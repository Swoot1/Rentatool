<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Application\Services;


use Application\Collections\RentPeriodCollection;
use Application\Factories\MailFactory;
use Application\Mappers\RentPeriodMapper;
use Application\Models\MailContent;
use Application\Models\RentPeriod;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class RentPeriodService{
   private $rentPeriodMapper;
   private $rentPeriodValidationService;
   private $rentalObjectService;

   public function __construct(RentPeriodMapper $rentPeriodMapper,
                               RentPeriodValidationService $rentPeriodValidationService,
                               RentalObjectService $rentalObjectService){
      $this->rentPeriodMapper            = $rentPeriodMapper;
      $this->rentPeriodValidationService = $rentPeriodValidationService;
      $this->rentalObjectService         = $rentalObjectService;
   }

   public function read($id){
      $rentPeriodData = $this->rentPeriodMapper->read($id);

      if ($rentPeriodData === null){
         throw new ApplicationException('Kunde inte hitta uthyrningsperiod.');
      }

      return new RentPeriod($rentPeriodData);

   }

   public function create(array $data, User $currentUser){
      $rentPeriod = $this->getCalculatedPricePlan($data, $currentUser);
      $this->rentPeriodValidationService->checkIsValidRentPeriod($rentPeriod);
      $rentPeriodData = $this->rentPeriodMapper->create($rentPeriod->getDBParameters());

      return new RentPeriod($rentPeriodData);
   }

   public function cancelRentPeriod($id, $currentUser){
      $rentPeriod = $this->read($id);
      $this->rentPeriodValidationService->checkCurrentUserIsRenter($currentUser, $rentPeriod);
      $this->rentPeriodMapper->cancelRentPeriod($id);

      return $rentPeriod;
   }

   public function getCalculatedPricePlan(array $data, User $currentUser){
      $rentPeriod   = new RentPeriod(array_merge(array('renterId' => $currentUser->getId()), $data));
      $rentalObject = $this->rentalObjectService->read($rentPeriod->getRentalObjectId());
      $rentPeriod->setPricePerDayFromRentalObject($rentalObject);

      return $rentPeriod;
   }

   public function index(User $user){
      $filterData = array('userId' => $user->getId());
      $result     = $this->rentPeriodMapper->index($filterData);

      return new RentPeriodCollection($result);
   }
}