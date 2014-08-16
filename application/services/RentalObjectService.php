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

class RentalObjectService {
   /**
    * @var \Rentatool\Application\Mappers\RentalObjectMapper
    */
   private $rentalObjectMapper;

   public function __construct(RentalObjectMapper $rentalObjectMapper) {
      $this->rentalObjectMapper = $rentalObjectMapper;
   }

   public function index(RentalObjectFilter $rentalObjectFilter) {
      $rentalObjectData = $this->rentalObjectMapper->index($rentalObjectFilter);

      return new RentalObjectCollection($rentalObjectData);
   }

   public function create(array $data, User $currentUser) {
      $rentalObjectModel = new RentalObject(array_merge(array('userId' => $currentUser->getId()), $data));
      $DBParameters      = $rentalObjectModel->getDBParameters();
      $result            = $this->rentalObjectMapper->create($DBParameters);

      return $rentalObjectModel;
   }

   public function read($id) {
      $rentalObjectData = $this->rentalObjectMapper->read($id);

      return $rentalObjectData ? new RentalObject($rentalObjectData) : null;
   }

   public function update($id, $requestData) {
      $savedRentalObject = $this->read($id);

      if ($savedRentalObject == null) {
         throw new NotFoundException('Kunde inte hitta uthyrningsobjekt.');
      }

      $rentalObject = new RentalObject($requestData);

      $this->rentalObjectMapper->update($rentalObject->getDBParameters());

      return $requestData ? new RentalObject($requestData) : null;
   }

   public function delete($id) {
      return $this->rentalObjectMapper->delete($id);
   }
}