<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 17:08
 */

namespace Tests\CollectionTest;


use Application\Collections\FileCollection;
use Application\Models\File;
use Application\Models\RentalObject;

class FileCollectionTest extends \PHPUnit_Framework_TestCase{


   public function testGetDependencyCollection(){
      $files          = array(
         new File(array('id' => 2))
      );
      $fileCollection = new FileCollection($files);

      $rentalObject = new RentalObject(array('id' => 1));

      $fileDependencies = $fileCollection->getDependencyCollection($rentalObject);

      $this->assertInstanceOf('Application\Collections\RentalObjectFileDependencyCollection', $fileDependencies);
      $fileDependenciesData = $fileDependencies->getDBParameters();

      $this->assertEquals(1, $fileDependenciesData[0]['rentalObjectId']);
      $this->assertEquals(2, $fileDependenciesData[0]['fileId']);
   }

} 