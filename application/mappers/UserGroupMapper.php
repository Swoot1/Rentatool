<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:54
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;


class UserGroupMapper{

   private $indexSQL = '
      SELECT
         id,
         name,
         description
      FROM
        user_groups
   ';

   private $createSQL = '
      INSERT INTO
        user_groups
        (
          name,
          description
        )
      VALUES
        (
          :name,
          :description
        )
   ';

   private $readSQL = '
      SELECT
         id,
         name,
         description
      FROM
        user_groups
      WHERE
        id = :id
   ';

   private $updateSQL = '
      UPDATE
         user_groups
      SET
        name = :name,
        description = :description
      WHERE
        id = :id
   ';

   private $deleteSQL = '
      DELETE FROM
        user_groups
      WHERE
        id = :id
   ';


   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }


   public function index(){
      $userGroups = $this->databaseConnection->runQuery($this->indexSQL);

      return $userGroups;
   }


   public function read($id){
      $userGroup = $this->databaseConnection->runQuery($this->readSQL, ['id' => $id]);

      return array_shift($userGroup);
   }


   public function create(array $DBParameters){
      unset($DBParameters['id']);

      return $this->databaseConnection->runQuery($this->createSQL, $DBParameters);
   }


   public function update(array $DBParameters){
      return $this->databaseConnection->runQuery($this->updateSQL, $DBParameters);
   }


   public function delete($id){
      return $this->databaseConnection->runQuery($this->deleteSQL, ['id' => $id]);
   }
}