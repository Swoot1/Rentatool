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
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\Mappers\FileMapper;
use Application\Models\File;
use Application\Models\RentalObject;
use Application\Models\RentalObjectFileDependency;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;

class FileService{

   protected $fileMapper;

   public function __construct(FileMapper $fileMapper){
      $this->fileMapper = $fileMapper;
   }

   public function getRentalObjectFileCollection($id){
      $result = $this->fileMapper->getRentalObjectFileCollection($id);

      return new FileCollection($result);
   }

   public function create(array $data){
      $file     = $this->buildFile($data);
      $fileData = $this->fileMapper->create($file->getDBParameters());
      $file     = new File($fileData);
      $this->moveFile($data, $file);

      return $file;
   }

   private function moveFile(array $data, File $file){
      try{
         $photoPath = sprintf('%sPublic/RentalObjectPhotos/%s.%s', PROJECT_ROOT, $file->getId(), pathinfo(array_shift($data['name']), PATHINFO_EXTENSION));
         $tmpName   = array_shift($data['tmp_name']);
         $this->checkFileExists($tmpName);
         rename($tmpName, $photoPath);
      } catch (Exception $e){
         throw new ApplicationException('Fel vid uppladdning av bild.');
      }
   }

   private function checkFileExists($fileName){
      $fileExists = file_exists($fileName);

      if ($fileExists === false){
         throw new NotFoundException('Kunde inte koppa bilden till uthyrningsobjektet.');
      }

      return true;
   }

   private function buildFile(array $data){
      $fileData = array();
      try{
         $fileName      = array_shift($data['name']);
         $fileNameParts = explode('.', $fileName);

         $fileData['fileType']      = array_shift($data['type']);
         $fileData['fileSize']      = array_shift($data['size']);
         $fileData['fileExtension'] = array_pop($fileNameParts);
      } catch (Exception $exception){
         throw new ApplicationException('Fel vid uppladdning av bild.');
      }

      return new File($fileData);
   }

   public function setDependencies(FileCollection $fileCollection, RentalObject $rentalObject){
      $dependencyCollection     = $fileCollection->getDependencyCollection($rentalObject);
      $dependencyCollectionData = $dependencyCollection->getDBParameters();
      $result                   = [];

      foreach ($dependencyCollectionData as $data){
         $result[] = $this->createDependency($data);
      }

      return new RentalObjectFileDependencyCollection($result);

   }

   private function createDependency(array $data){
      $result = $this->fileMapper->createDependency($data);

      return new RentalObjectFileDependency($result);
   }
} 