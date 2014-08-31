<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\RentalObjectCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Filters\RentalObjectFilter;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Models\RentalObject;
use Rentatool\Application\Models\User;

class RentalObjectService{
   /**
    * @var \Rentatool\Application\Mappers\RentalObjectMapper
    */
   private $rentalObjectMapper;
   private $pricePlanService;

   /**
    * @param RentalObjectMapper $rentalObjectMapper
    * @param PricePlanService $pricePlanService
    */
   public function __construct(RentalObjectMapper $rentalObjectMapper, PricePlanService $pricePlanService){
      $this->rentalObjectMapper = $rentalObjectMapper;
      $this->pricePlanService   = $pricePlanService;

      return $this;
   }

   /**
    * @param RentalObjectFilter $rentalObjectFilter
    * @return RentalObjectCollection
    */
   public function index(RentalObjectFilter $rentalObjectFilter){
      $rentalObjectData = $this->rentalObjectMapper->index($rentalObjectFilter);

      return new RentalObjectCollection($rentalObjectData);
   }

   /**
    * @param array $data
    * @param User $currentUser
    * @return RentalObject
    */
   public function create(array $data, User $currentUser){
      $rentalObject        = new RentalObject(array_merge(array('userId' => $currentUser->getId()), $data));
      $pricePlanCollection = $rentalObject->getPricePlanCollection();
      $DBParameters        = $rentalObject->getDBParameters();
      $rentalObjectData    = $this->rentalObjectMapper->create($DBParameters);
      $rentalObject        = new RentalObject($rentalObjectData);
      $this->pricePlanService->createFromCollection($pricePlanCollection, $rentalObject);

      return $rentalObject;
   }

   /**
    * @param $id
    * @return null|RentalObject
    */
   public function read($id){
      $rentalObjectData                        = $this->rentalObjectMapper->read($id);
      $rentalObjectData['pricePlanCollection'] = $this->pricePlanService->readCollectionFromRentalObjectId($id);;

      return $rentalObjectData ? new RentalObject($rentalObjectData) : null;
   }

   /**
    * @param $id
    * @param $requestData
    * @return RentalObject
    */
   public function update($id, $requestData){
      $this->checkIfRentalObjectExist($id);
      $rentalObject = new RentalObject($requestData);
      $this->rentalObjectMapper->update($rentalObject->getDBParameters());

      return $rentalObject;
   }

   /**
    * @param $id
    * @return $this
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException
    */
   private function checkIfRentalObjectExist($id){
      $savedRentalObject = $this->read($id);

      if ($savedRentalObject == null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjekt.');
      }

      return $this;
   }

   public function delete($id){
      return $this->rentalObjectMapper->delete($id);
   }
}