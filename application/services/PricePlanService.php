<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 20:54
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Mappers\PricePlanMapper;
use Rentatool\Application\Models\PricePlan;

class PricePlanService {
   protected $pricePlanMapper;

   public function __construct(PricePlanMapper $pricePlanMapper){
      $this->pricePlanMapper = $pricePlanMapper;
   }

   public function create(array $data){
      $pricePlan = new PricePlan($data);

      $this->pricePlanMapper->create($pricePlan->getDBParameters());
   }
} 