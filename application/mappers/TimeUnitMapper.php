<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 17/08/14
 * Time: 14:39
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class TimeUnitMapper{

   private $createSQL = '
      INSERT INTO
        time_unit
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
        time_unit
   ';

   private $updateSQL = '
      UPDATE
         time_unit
      SET
        name = :name
      WHERE
        id = :id
   ';

   private $deleteSQL = '
      DELETE FROM
          time_unit
      WHERE
         id = :id
   ';

   private $indexSQL = '
      SELECT
         id,
         name
      FROM
        time_unit
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