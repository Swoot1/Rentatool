<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:21
 */

namespace Application\Mappers;

use Application\PHPFramework\Database\Models\IDatabaseConnection;

class ResetPasswordMapper{

   private $databaseConnection;

   private $readSQL = '
      SELECT
        id,
        user_id AS "userId",
        expiration_timestamp AS "expirationTimestamp",
        reset_code AS "resetCode"
      FROM
        reset_passwords
      WHERE
        id = :id
   ';

   private $createSQL = '
      INSERT INTO
        reset_passwords
        (
          user_id,
          reset_code,
          expiration_timestamp
        )
        VALUES
        (
          :userId,
          :resetCode,
          now() + INTERVAL 1 DAY
        )
   ';

   private $readActiveResetPasswordSQL = '
      SELECT
         id,
         user_id AS "userId",
         reset_code AS "resetCode",
         expiration_timestamp AS "expirationTimestamp"
      FROM
        reset_passwords
      WHERE
        reset_code = :resetCode
      AND
        expiration_timestamp > now()
   ';

   private $deleteSQL = '
      DELETE FROM
        reset_passwords
      WHERE
        id = :id
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));

      return array_shift($result);
   }

   public function create(array $DBParameters){
      unset($DBParameters['id']);
      unset($DBParameters['expirationTimestamp']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $DBParameters);

      return $this->read($result['lastInsertId']);
   }

   public function readActiveResetPassword($resetCode){
      $result = $this->databaseConnection->runQuery($this->readActiveResetPasswordSQL, array('resetCode' => $resetCode));

      return array_shift($result);
   }

   public function delete($id){
      $this->databaseConnection->runQuery($this->deleteSQL, array('id' => $id));
   }
}