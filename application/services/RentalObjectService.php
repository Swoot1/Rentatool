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

   public function __construct(RentalObjectMapper $rentalObjectMapper, PricePlanService $pricePlanService){
      $this->rentalObjectMapper = $rentalObjectMapper;
      $this->pricePlanService = $pricePlanService;
   }

   public function index(RentalObjectFilter $rentalObjectFilter){
      $rentalObjectData = $this->rentalObjectMapper->index($rentalObjectFilter);

      return new RentalObjectCollection($rentalObjectData);
   }

   public function create(array $data, User $currentUser){
      $rentalObject = new RentalObject(array_merge(array('userId' => $currentUser->getId()), $data));
      $DBParameters      = $rentalObject->getDBParameters();

      // TODO tidy up this function
      $pricePlanCollection = $rentalObject->getPricePlanCollection();
      unset($DBParameters['pricePlanCollection']);
      $rentalObjectData  = $this->rentalObjectMapper->create($DBParameters);
      $rentalObject = new RentalObject($rentalObjectData);

      $this->pricePlanService->createFromCollection($pricePlanCollection, $rentalObject->getId());

      return $rentalObject;
   }

   public function read($id){
      $rentalObjectData = $this->rentalObjectMapper->read($id);
      $rentalObjectData['pricePlanCollection'] = $this->pricePlanService->readCollectionFromRentalObjectId($id);;
      return $rentalObjectData ? new RentalObject($rentalObjectData) : null;
   }

   // TODO tidy up this function
   public function update($id, $requestData){
      $savedRentalObject = $this->read($id);

      if ($savedRentalObject == null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjekt.');
      }

      $rentalObject = new RentalObject($requestData);

      $DBData = $rentalObject->getDBParameters();
      unset($DBData['pricePlanCollection']);
      $this->rentalObjectMapper->update($DBData);
      return $rentalObject;
   }

   public function delete($id){
      return $this->rentalObjectMapper->delete($id);
   }
}