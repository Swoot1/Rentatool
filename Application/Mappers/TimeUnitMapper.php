<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 14:39
 */

namespace Application\Mappers;


use Application\ENFramework\Models\IDatabaseConnection;

class TimeUnitMapper{

   private $createSQL = '
      INSERT INTO
        time_units
        (
          name
        )
        VALUES
        (
          :name
        )
   ';

   private $readSQL = '
      SELECT
         id,
         name
      FROM
        time_units
   ';

   private $updateSQL = '
      UPDATE
         time_units
      SET
        name = :name
      WHERE
        id = :id
   ';

   private $deleteSQL = '
      DELETE FROM
          time_units
      WHERE
         id = :id
   ';

   private $indexSQL = '
      SELECT
         id,
         name
      FROM
        time_units
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $data){
      unset($data['id']);
      $this->databaseConnection->runQuery($this->createSQL, $data);
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));
      return array_shift($result);
   }

   public function index(){
      return $this->databaseConnection->runQuery($this->indexSQL);
   }

   public function update($data){
      return $this->databaseConnection->runQuery($this->updateSQL, $data);
   }

   public function delete($id){
      $this->databaseConnection->runQuery($this->deleteSQL, array('id' => $id));
   }
} 