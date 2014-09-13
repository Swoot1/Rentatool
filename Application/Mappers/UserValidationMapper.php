<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/08/14
 * Time: 15:58
 */

namespace Application\Mappers;


use Application\ENFramework\Models\IDatabaseConnection;

class UserValidationMapper{

   private $isUniqueUsernameSQL = '
      SELECT (SELECT COUNT(username) FROM users WHERE username = :username AND id != COALESCE(:userId, 0)) AS "numberOfUsers";
   ';

   private $isUniqueEmailSQL = '
      SELECT (SELECT COUNT(email) FROM users WHERE email = :email AND id != COALESCE(:userId, 0)) AS "numberOfUsers";
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   /**
    * @param $userId
    * @param $username
    * @return bool
    */
   public function isUniqueUsername($userId, $username){
      $result           = $this->databaseConnection->runQuery($this->isUniqueUsernameSQL, array('username' => $username, 'userId' => $userId));
      $isUniqueUsername = (int)array_pop($result)['numberOfUsers'] === 0;

      return $isUniqueUsername;
   }

   /**
    * @param $userId
    * @param $email
    * @return bool
    */
   public function isUniqueEmail($userId, $email){
      $result        = $this->databaseConnection->runQuery($this->isUniqueEmailSQL, array('email' => $email, 'userId' => $userId));
      $isUniqueEmail = (int)array_pop($result)['numberOfUsers'] === 0;

      return $isUniqueEmail;
   }
} 
