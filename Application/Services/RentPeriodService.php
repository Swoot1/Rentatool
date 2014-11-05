<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Application\Services;


use Application\Collections\RentPeriodCollection;
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

   public function create(array $data, User $currentUser){
      $data['isConfirmedByOwner'] = false;
      $rentPeriod                 = $this->getCalculatedPricePlan($data, $currentUser);
      $this->rentPeriodValidationService->checkIsValidRentPeriod($rentPeriod);
      $rentPeriodData = $this->rentPeriodMapper->create($rentPeriod->getDBParameters());

      return new RentPeriod($rentPeriodData);
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

   public function confirmRentPeriod($id, User $currentUser){

      $isOwner = $this->rentPeriodMapper->isRentalObjectOwner($id, $currentUser->getId());

      if ($isOwner === false){
         throw new ApplicationException('Kan inte godkänna uthyrningsperioder vars uthyrningsobjekt du inte är ägare av.');
      }

      $this->rentPeriodMapper->confirmRentPeriod($id);

      return true;
   }
}