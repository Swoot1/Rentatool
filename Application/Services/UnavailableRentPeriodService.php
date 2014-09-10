<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:22
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Collections\UnavailableRentPeriodCollection;
use Rentatool\Application\Filters\UnavailableRentPeriodFilter;
use Rentatool\Application\Mappers\UnavailableRentPeriodMapper;

class UnavailableRentPeriodService {

   private $unavailableRentPeriodMapper;

   public function __construct(UnavailableRentPeriodMapper $unavailableRentPeriodsMapper){
      $this->unavailableRentPeriodMapper = $unavailableRentPeriodsMapper;
   }

   public function index(UnavailableRentPeriodFilter $unavailableRentPeriodFilter){
      $data = $this->unavailableRentPeriodMapper->index($unavailableRentPeriodFilter);
      return new UnavailableRentPeriodCollection($data);
   }
} 