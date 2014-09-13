<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/09/14
 * Time: 11:27
 */

namespace Rentatool\Application\Collections;


use Rentatool\Application\ENFramework\Collections\GeneralCollection;
use Rentatool\Application\Models\File;
use Rentatool\Application\Models\RentalObject;

class FileCollection extends GeneralCollection{
   protected $model = 'Rentatool\Application\Models\File';

   public function getDependencyCollection(RentalObject $rentalObject){
      $rentalObjectFileDependencies = array();

      foreach ($this->data as $file){
         $rentalObjectFileDependencies[] = $this->buildRentalObjectFileDependencyData($file, $rentalObject);
      }

      return new RentalObjectFileDependencyCollection($rentalObjectFileDependencies);
   }

   private function buildRentalObjectFileDependencyData(File $file, RentalObject $rentalObject){
      return
         array(
            'rentalObjectId' => $rentalObject->getId(),
            'fileId'         => $file->getId()
         );
   }
} 