<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:21
 */

namespace Application\Mappers;

use Application\ENFramework\Models\IDatabaseConnection;

class ResetPasswordMapper {

   private $databaseConnection;

   private $readSQL = '
      SELECT
        id,
        user_id AS "userId",
        created_timestamp AS "createdTimestamp",
        reset_code AS "resetCode"
      FROM
        reset_password
      WHERE
        id = :id
   ';

   private $createSQL = '
      INSERT INTO
        reset_password
        (
          user_id,
          reset_code
        )
        VALUES
        (
          :userId,
          :resetCode
        )
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection  = $databaseConnection;
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));
      return array_shift($result);
   }

   public function create(array $DBParameters){
      unset($DBParameters['id']);
      unset($DBParameters['createdTimestamp']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $DBParameters);
      return $this->read($result['lastInsertId']);
   }
}