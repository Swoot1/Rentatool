<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\RentalObjectCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
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
      $this->pricePlanService->createFromCollection($pricePlanCollection, $rentalObject, $currentUser, $this);

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
    * @param $requestData
    * @param $currentUser
    * @return RentalObject
    * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    */
   public function update($requestData, $currentUser){
      $this->checkIfRentalObjectExist($requestData['id']);
      $rentalObject = new RentalObject($requestData);
      if($rentalObject->isOwner($currentUser)){
         $this->rentalObjectMapper->update($rentalObject->getDBParameters());
      }else{
         throw new ApplicationException('Kan inte uppdatera objekt som du inte är ägare av.');
      }


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

   public function delete($id, $currentUser){

      $rentalObject = $this->read($id);

      if($rentalObject === null){
         throw new NotFoundException('Kunde inte hitta valt uthyrningsobjekt för borttagning.');
      }

      if($rentalObject->isOwner($currentUser)){
         $this->rentalObjectMapper->delete($id);
      }else{
         throw new ApplicationException('Kan inte ta bort objekt som du inte är ägare av.');
      }
   }
}