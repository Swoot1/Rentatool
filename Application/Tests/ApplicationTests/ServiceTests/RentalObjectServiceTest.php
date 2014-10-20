<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 23:09
 */

namespace Tests\ServiceTests;


use Application\Services\RentalObjectService;

class RentalObjectServiceTest extends \PHPUnit_Framework_TestCase{
   public function testIndex(){

      $rentalObjectMapperMock = $this->getMockBuilder('Application\Mappers\RentalObjectMapper')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectMapperMock->expects($this->once())
                             ->method('index')
                             ->will($this->returnValue(array()));

      $fileServiceMock = $this->getMockBuilder('Application\Services\FileService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectFilterMock = $this->getMockBuilder('Application\Filters\RentalObjectFilter')
                                     ->disableOriginalConstructor()
                                     ->getMock();

      $rentalObjectService    = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock);
      $rentalObjectCollection = $rentalObjectService->index($rentalObjectFilterMock);
      $this->assertInstanceOf('Application\Collections\RentalObjectCollection', $rentalObjectCollection);
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
                      ->method('getRentalObjectCollection')
                      ->will($this->returnValue($fileCollectionMock));

      $rentalObjectService    = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock);
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

      $rentalObjectService = new RentalObjectService($rentalObjectMapperMock, $fileServiceMock);
      $rentalObjectService->read(1);
   }
} 