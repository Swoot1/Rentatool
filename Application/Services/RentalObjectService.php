<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 */

namespace Application\Services;

use Application\Collections\RentalObjectCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\Filters\RentalObjectFilter;
use Application\Mappers\RentalObjectMapper;
use Application\Models\RentalObject;
use Application\Models\User;

class RentalObjectService{
   /**
    * @var \Application\Mappers\RentalObjectMapper
    */
   private $rentalObjectMapper;
   private $fileService;

   public function __construct(RentalObjectMapper $rentalObjectMapper, FileService $fileService){
      $this->rentalObjectMapper = $rentalObjectMapper;
      $this->fileService        = $fileService;

      return $this;
   }

   public function index(RentalObjectFilter $rentalObjectFilter){
      $rentalObjectData = $this->rentalObjectMapper->index($rentalObjectFilter);

      return new RentalObjectCollection($rentalObjectData);
   }

   public function create(array $data, User $currentUser){
      $rentalObject     = new RentalObject(array_merge(array('userId' => $currentUser->getId()), $data));
      $fileCollection   = $rentalObject->getFileCollection();
      $DBParameters     = $rentalObject->getDBParameters();
      $rentalObjectData = $this->rentalObjectMapper->create($DBParameters);
      $rentalObject     = new RentalObject($rentalObjectData);
      $this->fileService->setDependencies($rentalObject, $fileCollection);
      $rentalObject->setFileCollection($this->fileService->getRentalObjectCollection($rentalObject->getId()));

      return $rentalObject;
   }

   public function read($id){
      $rentalObjectData                   = $this->rentalObjectMapper->read($id);
      $rentalObjectData['fileCollection'] = ($this->fileService->getRentalObjectCollection($id));

      return $rentalObjectData ? new RentalObject($rentalObjectData) : null;
   }

   public function update($requestData, $currentUser){
      $this->checkIfRentalObjectExist($requestData['id']);
      $rentalObject = new RentalObject($requestData);
      if ($rentalObject->isOwner($currentUser)){
         $this->rentalObjectMapper->update($rentalObject->getDBParameters());
      } else{
         throw new ApplicationException('Kan inte uppdatera objekt som du inte är ägare av.');
      }


      return $rentalObject;
   }

   private function checkIfRentalObjectExist($id){
      $savedRentalObject = $this->read($id);

      if ($savedRentalObject == null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjekt.');
      }

      return $this;
   }

   public function delete($id, $currentUser){

      $rentalObject = $this->read($id);

      if ($rentalObject === null){
         throw new NotFoundException('Kunde inte hitta valt uthyrningsobjekt för borttagning.');
      }

      if ($rentalObject->isOwner($currentUser)){
         $this->rentalObjectMapper->delete($id);
      } else{
         throw new ApplicationException('Kan inte ta bort objekt som du inte är ägare av.');
      }
   }
}