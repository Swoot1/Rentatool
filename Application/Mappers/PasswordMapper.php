<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/10/14
 * Time: 10:18
 */

namespace Application\Mappers;


use Application\ENFramework\Database\Models\IDatabaseConnection;

class PasswordMapper{
   private $databaseConnection;

   private $createSQL = '
      UPDATE
        users
      SET
         password = :password
      WHERE
        id = :userId
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function create(array $DBParameters){
      $this->databaseConnection->runQuery($this->createSQL, $DBParameters);
   }
} 