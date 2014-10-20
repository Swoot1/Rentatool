<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 */

namespace Application\Services;

use Application\Collections\FileCollection;
use Application\Collections\RentalObjectCollection;
use Application\Filters\RentalObjectFilter;
use Application\Mappers\RentalObjectMapper;
use Application\Models\RentalObject;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;

class RentalObjectService{
   /**
    * @var \Application\Mappers\RentalObjectMapper
    */
   private $rentalObjectMapper;
   private $fileService;
   private $rentalObjectValidationService;

   public function __construct(RentalObjectMapper $rentalObjectMapper, FileService $fileService, RentalObjectValidationService $rentalObjectValidationService){
      $this->rentalObjectMapper            = $rentalObjectMapper;
      $this->fileService                   = $fileService;
      $this->rentalObjectValidationService = $rentalObjectValidationService;

      return $this;
   }

   public function index(RentalObjectFilter $rentalObjectFilter){
      $rentalObjectData = $this->rentalObjectMapper->index($rentalObjectFilter);

      return new RentalObjectCollection($rentalObjectData);
   }

   public function create(array $data, User $currentUser){
      $rentalObject       = new RentalObject(array_merge(array('userId' => $currentUser->getId()), $data));
      $rentalObjectData   = $this->rentalObjectMapper->create($rentalObject->getDBParameters());
      $rentalObject       = new RentalObject($rentalObjectData);
      $fileCollectionData = array_key_exists('fileCollection', $data) ? $data['fileCollection'] : array();
      $rentalObject       = $this->createFileCollection($fileCollectionData, $rentalObject);

      return $rentalObject;
   }

   private function createFileCollection(array $fileCollectionData, RentalObject $rentalObject){
      $fileCollection = new FileCollection($fileCollectionData);
      $this->fileService->setDependencies($fileCollection, $rentalObject);
      $rentalObjectCollection = $this->fileService->getRentalObjectFileCollection($rentalObject->getId());
      $rentalObject->setFileCollection($rentalObjectCollection);

      return $rentalObject;
   }

   public function read($id){
      $rentalObjectData = $this->rentalObjectMapper->read($id);

      if ($rentalObjectData === null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjektet.');
      }

      $rentalObjectData['fileCollection'] = $this->fileService->getRentalObjectFileCollection($id);

      return new RentalObject($rentalObjectData);
   }

   public function update($requestData, $currentUser){
      $this->rentalObjectValidationService->validateUpdate($this, $requestData['id'], $currentUser);
      $rentalObject = new RentalObject($requestData);
      $this->rentalObjectMapper->update($rentalObject->getDBParameters());

      return $rentalObject;
   }

   public function delete($id, $currentUser){
      $this->rentalObjectValidationService->validateDelete($this, $id, $currentUser);
      $this->rentalObjectMapper->delete($id);
   }
}