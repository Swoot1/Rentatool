<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 20/10/14
 * Time: 21:50
 */

namespace Application\Services;

use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;

class RentalObjectValidationService {

   public function validateUpdate(RentalObjectService $rentalObjectService, $id, User $currentUser){

      $rentalObject = $rentalObjectService->read($id);

      if ($rentalObject == null){
         throw new NotFoundException('Kunde inte hitta uthyrningsobjektet.');
      }

      if ($rentalObject->isOwner($currentUser) === false){
         throw new ApplicationException('Kan inte uppdatera uthyrningsobjekt som du inte är ägare av.');
      }

      return true;
   }

   public function validateInactivation(RentalObjectService $rentalObjectService, $id, User $currentUser){

      $rentalObject = $rentalObjectService->read($id);

      if ($rentalObject === null){
         throw new NotFoundException('Kunde inte hitta valt uthyrningsobjekt för inaktivering.');
      }

      if ($rentalObject->isOwner($currentUser) === false){
         throw new ApplicationException('Kan inte inaktivera uthyrningsobjekt som du inte är ägare av.');
      }

      return true;
   }
} 