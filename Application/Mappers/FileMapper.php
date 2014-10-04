<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 17:14
 */

namespace Application\Mappers;

use Application\ENFramework\Database\Models\IDatabaseConnection;

class FileMapper{

   private $databaseConnection;

   private $getRentalObjectCollectionSQL = '
      SELECT
         files.id,
         file_type AS "fileType",
         file_size AS "fileSize"
      FROM
        files
      LEFT JOIN
        rental_object_file_dependencies
      ON
        rental_object_file_dependencies.file_id = files.id
      WHERE
        rental_object_file_dependencies.rental_object_id = :rentalObjectId
   ';

   private $readSQL = '
      SELECT
         id,
         file_type AS "fileType",
         file_size AS "fileSize"
      FROM
        files
      WHERE
         id = :id
   ';

   private $createSQL = '
      INSERT INTO files
        (
          file_type,
          file_size
       )
       VALUES
        (
          :fileType,
          :fileSize
          )
   ';

   private $readRentalObjectFileDependencySQL = '
      SELECT
         id,
         rental_object_id AS "rentalObjectId",
         file_id AS "fileId"
      FROM
        rental_object_file_dependencies
      WHERE
         id = :id
   ';

   private $createRentalObjectFileDependencySQL = '
      INSERT INTO
        rental_object_file_dependencies
        (
          rental_object_id,
          file_id
        )
        VALUES
        (
          :rentalObjectId,
          :fileId
        )
   ';


   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function getRentalObjectCollection($rentalObjectId){
      return $this->databaseConnection->runQuery(
                                      $this->getRentalObjectCollectionSQL,
                                      array('rentalObjectId' => $rentalObjectId)
      );
   }

   public function create(array $DBParameters){
      unset($DBParameters['id']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $DBParameters);

      return $this->read($result['lastInsertId']);
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));

      return array_shift($result);
   }

   private function readRentalObjectFileDependency($id){
      $result = $this->databaseConnection->runQuery($this->readRentalObjectFileDependencySQL, array('id' => $id));

      return array_shift($result);
   }

   public function createDependency(array $DBParameters){
      unset($DBParameters['id']);
      $result = $this->databaseConnection->runQuery($this->createRentalObjectFileDependencySQL, $DBParameters);

      return $this->readRentalObjectFileDependency($result['lastInsertId']);
   }
} 