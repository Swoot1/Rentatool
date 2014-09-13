<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 17:13
 */

namespace Application\Services;


use Application\Collections\FileCollection;
use Application\Collections\RentalObjectFileDependencyCollection;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\Mappers\FileMapper;
use Application\Models\File;
use Application\Models\RentalObject;
use Application\Models\RentalObjectFileDependency;
use Symfony\Component\Config\Definition\Exception\Exception;

class FileService{

   protected $fileMapper;

   public function __construct(FileMapper $fileMapper){
      $this->fileMapper = $fileMapper;
   }

   public function getRentalObjectCollection($id){
      $result = $this->fileMapper->getRentalObjectCollection($id);
      return new FileCollection($result);
   }

   public function create(array $data){
      $file = $this->buildFile($data);
      $fileData = $this->fileMapper->create($file->getDBParameters());
      $file = new File($fileData);
      $photoPath = sprintf('%s/Rentatool/Public/RentalObjectPhotos/%s.%s', PROJECT_ROOT, $file->getId(), pathinfo(array_shift($data['name']), PATHINFO_EXTENSION));
      rename(array_shift($data['tmp_name']), $photoPath);
      return $file;
   }

   private function buildFile(array $data){
      $fileData = array();
      try{
         $fileData['fileType'] = array_shift($data['type']);
         $fileData['fileSize'] = array_shift($data['size']);
      }catch(Exception $exception){
         throw new ApplicationException('Fel vid uppladdning av bild.');
      }
      return new File($fileData);
   }

   public function setDependencies(RentalObject $rentalObject, FileCollection $fileCollection){
      $dependencyCollection = $fileCollection->getDependencyCollection($rentalObject);
      $dependencyCollectionData = $dependencyCollection->getDBParameters();

      foreach($dependencyCollectionData as $data){
         $result[] = $this->createDependency($data);
      }

      return new RentalObjectFileDependencyCollection($result);

   }

   private function createDependency(array $data){
      $result = $this->fileMapper->createDependency($data);

      return new RentalObjectFileDependency($result);
   }
} 