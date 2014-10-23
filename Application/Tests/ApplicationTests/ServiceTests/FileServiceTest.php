<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 20/10/14
 * Time: 23:12
 */

namespace Tests\ServiceTests;


use Application\Services\FileService;

class FileServiceTest extends \PHPUnit_Framework_TestCase{

   public function testGetRentalObjectFileCollection(){
      $fileMapperMock = $this->getMockBuilder('Application\Mappers\FileMapper')
                             ->disableOriginalConstructor()
                             ->getMock();

      $fileMapperMock->expects($this->once())
                     ->method('getRentalObjectFileCollection')
                     ->will($this->returnValue(array()));

      $fileService = new FileService($fileMapperMock);

      $fileCollection = $fileService->getRentalObjectFileCollection(1);

      $this->assertInstanceOf('Application\Collections\FileCollection', $fileCollection);

   }

   public function testSetDependencies(){
      $fileMapperMock = $this->getMockBuilder('Application\Mappers\FileMapper')
                             ->disableOriginalConstructor()
                             ->getMock();

      $fileMapperMock->expects($this->any())
                     ->method('createDependency')
                     ->will($this->returnValue(array()));

      $fileCollectionMock = $this->getMockBuilder('Application\Collections\FileCollection')
                                 ->disableOriginalConstructor()
                                 ->getMock();

      $rentalObjectFileDependencyCollectionMock = $this->getMockBuilder('Application\Collections\RentalObjectFileDependencyCollection')
                                                       ->disableOriginalConstructor()
                                                       ->getMock();

      $rentalObjectFileDependencyCollectionMock->expects($this->once())
                                               ->method('getDBParameters')
                                               ->will($this->returnValue(array(array('rentalObjectId' => 2, 'userId' => 1, 'fileId' => 3))));

      $fileCollectionMock->expects($this->any())
                         ->method('getDependencyCollection')
                         ->will($this->returnValue($rentalObjectFileDependencyCollectionMock));

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $fileService    = new FileService($fileMapperMock);
      $fileCollection = $fileService->setDependencies($fileCollectionMock, $rentalObjectMock);

      $this->assertInstanceOf('Application\Collections\RentalObjectFileDependencyCollection', $fileCollection);
   }


   /**
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException
    * @expectedExceptionMessage Kunde inte koppa bilden till uthyrningsobjektet.
    */
   public function testCreateNonExistingFile(){
      $fileMapperMock = $this->getMockBuilder('Application\Mappers\FileMapper')
                             ->disableOriginalConstructor()
                             ->getMock();

      $fileMapperMock->expects($this->any())
                     ->method('create')
                     ->will($this->returnValue(array('id' => 1)));


      $fileService = new FileService($fileMapperMock);
      $file        = $fileService->create(
                                 array(
                                    'type' => array('image/jpeg'),
                                    'size' => array(1773455),
                                    'name' => array('1234.jpg'),
                                    'tmp_name' => array('/Applications/MAMP/tmp/php/phpTGo4F0')
                                 )
      );
      $this->assertInstanceOf('Application\Models\File', $file);
   }
}