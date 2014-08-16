<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:39
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Mappers\RentPeriodMapper;
use Rentatool\Application\Models\RentPeriod;
use Rentatool\Application\Models\User;

class RentPeriodService{
   private $rentPeriodMapper;
   private $rentPeriodValidationService;

   public function __construct(RentPeriodMapper $rentPeriodMapper, RentPeriodValidationService $rentPeriodValidationService){
      $this->rentPeriodMapper = $rentPeriodMapper;
      $this->rentPeriodValidationService = $rentPeriodValidationService;
   }

   public function create(array $data, User $currentUser){
      $rentPeriod = new RentPeriod(array_merge(array('renterId' => $currentUser->getId()), $data));
      $this->rentPeriodValidationService->checkIsValidRentPeriod($rentPeriod);
      $this->rentPeriodMapper->create($rentPeriod->getDBParameters());
      return $rentPeriod;
   }
}