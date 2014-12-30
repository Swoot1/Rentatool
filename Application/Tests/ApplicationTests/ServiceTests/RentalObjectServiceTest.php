<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 23:09
 */

namespace Tests\ServiceTests;


use Application\Collections\FileCollection;
use Application\Services\RentalObjectService;

class RentalObjectServiceTest extends \PHPUnit_Framework_TestCase{
   public function testIndex(){

      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('index')
                             ->will($this->returnValue(
                                         array(
                                            array(
                                               'id'          => 1,
                                               'userId'      => 2,
                                               'name'        => 'Fräck husvagn',
                                               'description' => 'Överljudshastighets husvagn med sourroundsound.',
                                               'pricePerDay' => 200
                                            )
                                         )
                                    )
         );

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $fileServiceMock->expects($this->once())
                      ->method('getRentalObjectFileCollection')
                      ->will($this->returnValue(
                                  new FileCollection(
                                     array(
                                        array(
                                           'id'       => 1,
                                           'fileType' => 'image/jpeg',
                                           'fileSize' => 40000
                                        )
                                     )
                                  )
                             ));

      $rentalObjectFilterMock = $this->getMockBuilder('Application\Filters\RentalObjectFilter')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectService    = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);
      $rentalObjectCollection = $rentalObjectService->index($rentalObjectFilterMock);
      $this->assertInstanceOf('Application\Collections\RentalObjectCollection', $rentalObjectCollection);

      $rentalObjectCollectionData = $rentalObjectCollection->toArray();

      $this->assertEquals(1, $rentalObjectCollectionData[0]['fileCollection'][0]['id']);
   }

   public function testRead(){
      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('read')
                             ->will($this->returnValue(array()));

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();


      $fileCollectionMock = $this->getMockBuilder('Application\Collections\FileCollection')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $fileServiceMock->expects($this->once())
                      ->method('getRentalObjectFileCollection')
                      ->will($this->returnValue($fileCollectionMock));

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectService    = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);
      $rentalObjectCollection = $rentalObjectService->read(1);
      $this->assertInstanceOf('Application\Models\RentalObject', $rentalObjectCollection);
   }

   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte hitta uthyrningsobjektet.
    */
   public function testReadNotFound(){
      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('read')
                             ->will($this->returnValue(null));

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectService = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);
      $rentalObjectService->read(1);
   }

   public function testUpdate(){
      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('update')
                             ->will($this->returnValue(array()));

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectValidationServiceMock->expects($this->once())
                                        ->method('validateUpdate')
                                        ->will($this->returnValue(true));

      $rentalObjectService = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObject = $rentalObjectService->update(array('id' => 2), $currentUserMock);

      $this->assertInstanceOf('Application\Models\RentalObject', $rentalObject);
   }

   public function testDelete(){
      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('delete');

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectValidationServiceMock->expects($this->once())
                                        ->method('validateDelete')
                                        ->will($this->returnValue(true));

      $rentalObjectService = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectService->delete(2, $currentUserMock);
   }

   public function testCreate(){
      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('create')
                             ->will($this->returnValue(array()));

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $fileServiceMock->expects($this->once())
                      ->method('setDependencies');

      $fileServiceMock->expects($this->once())
                      ->method('getRentalObjectFileCollection')
                      ->will($this->returnValue(array()));

      $rentalObjectValidationServiceMock = $this->getMockBuilder('Application\Services\RentalObjectValidationService')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentalObjectService = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock, $rentalObjectValidationServiceMock);

      $currentUserMock = $this->getMockBuilder('Application\Models\User')
                              ->disableOriginalConstructor()
                              ->getMock();

      $currentUserMock->expects($this->once())
                      ->method('getId')
                      ->will($this->returnValue(1));

      $rentalObject = $rentalObjectService->create(array(), $currentUserMock);

      $this->assertInstanceOf('Application\Models\RentalObject', $rentalObject);
   }
} 