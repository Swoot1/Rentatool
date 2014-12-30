<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 20/10/14
 * Time: 22:56
 */

namespace Tests\ServiceTests;

use Application\Services\RentalObjectValidationService;

class RentalObjectValidationServiceTest extends \PHPUnit_Framework_TestCase{


   public function testValidateUpdate(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('isOwner')
                       ->will($this->returnValue(true));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $result = $rentalObjectValidationService->validateUpdate($rentalObjectServiceMock, 1, $currentUserMock);

      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Kan inte uppdatera uthyrningsobjekt som du inte är ägare av.
    */
   public function testValidateUpdateNotOwner(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('isOwner')
                       ->will($this->returnValue(false));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $rentalObjectValidationService->validateUpdate($rentalObjectServiceMock, 1, $currentUserMock);

   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte hitta uthyrningsobjektet.
    */
   public function testValidateUpdateNotFound(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue(null));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $rentalObjectValidationService->validateUpdate($rentalObjectServiceMock, 1, $currentUserMock);

   }

   public function testValidateDelete(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('isOwner')
                       ->will($this->returnValue(true));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $result = $rentalObjectValidationService->validateDelete($rentalObjectServiceMock, 1, $currentUserMock);

      $this->assertTrue($result);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Kan inte inaktivera uthyrningsobjekt som du inte är ägare av.
    */
   public function testValidateInactivateNotOwner(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('isOwner')
                       ->will($this->returnValue(false));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $rentalObjectValidationService->validateInactivation($rentalObjectServiceMock, 1, $currentUserMock);

   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte hitta valt uthyrningsobjekt för borttagning.
    */
   public function testValidateDeleteNotFound(){

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue(null));

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationService = new RentalObjectValidationService();

      $rentalObjectValidationService->validateDelete($rentalObjectServiceMock, 1, $currentUserMock);

   }
} 