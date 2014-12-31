<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-12-30
 * Time: 20:28
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Mappers;


use Application\PHPFramework\Database\Models\IDatabaseConnection;

class RentalNotificationMapper {

   private $getRenterInfoSQL = '
      SELECT
         users.email AS "renterEmail",
         rentalobjects.name AS "rentalObjectName"
     FROM users
     LEFT JOIN rental_objects rentalobjects
     ON users.id = rentalobjects.user_id
     WHERE rentalobjects.id = :rentalObjectId
   ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function read($rentalObjectId) {
      $result = $this->databaseConnection->runQuery($this->getRenterInfoSQL, ['rentalObjectId' => $rentalObjectId]);
      return array_pop($result);
   }

}