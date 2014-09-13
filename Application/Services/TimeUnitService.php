<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 15:04
 */

namespace Application\Services;

use Application\Collections\TimeUnitCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\Mappers\TimeUnitMapper;
use Application\Models\RentalObject;
use Application\Models\TimeUnit;

class TimeUnitService {

   private $timeUnitMapper;

   public function __construct(TimeUnitMapper $timeUnitMapper){
      $this->timeUnitMapper = $timeUnitMapper;
   }

   public function create(array $data){
      $timeUnit = new TimeUnit($data);
      $this->timeUnitMapper->create($timeUnit->getDBParameters());
      return $timeUnit;
   }

   public function read($id){
      $timeUnitData = $this->timeUnitMapper->read($id);

      return $timeUnitData ? new TimeUnit($timeUnitData) : null;
   }

   public function index(){
      $timeUnitData = $this->timeUnitMapper->index();
      return new TimeUnitCollection($timeUnitData);
   }

   public function update($id, $data) {
      $savedTimeUnit = $this->read($id);

      if ($savedTimeUnit == null) {
         throw new NotFoundException('Kunde inte hitta tidsenhet.');
      }

      $timeUnit = new TimeUnit($data);

      $this->timeUnitMapper->update($timeUnit->getDBParameters());

      return $data ? new TimeUnit($data) : null;
   }

   public function delete($id){
      return $this->timeUnitMapper->delete($id);
   }
} 