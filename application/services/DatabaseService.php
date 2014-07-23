<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Mappers\DatabaseMapper;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Mappers\UserMapper;

class DatabaseService {

   /**
    * @var \Rentatool\Application\Mappers\DatabaseMapper
    */
   protected $databaseMapper;

   public function __construct(DatabaseMapper $databaseMapper) {
      $this->databaseMapper = $databaseMapper;
   }

   public function create() {
//      $this->databaseMapper->createDatabase();
      $this->databaseMapper->createTables();
   }

   public function insertSeeds(UserMapper $userMapper, RentalObjectMapper $rentalObjectMapper) {
      $this->databaseMapper->insertSeeds($userMapper, $rentalObjectMapper);
   }
}