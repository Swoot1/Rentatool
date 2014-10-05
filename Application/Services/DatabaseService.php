<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Application\Services;

use Application\Mappers\DatabaseMapper;
use Application\Mappers\RentalObjectMapper;
use Application\Mappers\TimeUnitMapper;
use Application\Mappers\UserMapper;

class DatabaseService{

   /**
    * @var \Application\Mappers\DatabaseMapper
    */
   protected $databaseMapper;

   public function __construct(DatabaseMapper $databaseMapper){
      $this->databaseMapper = $databaseMapper;
   }

   public function create(){
//      $this->databaseMapper->createDatabase();
      $this->databaseMapper->createTables();
   }

   public function createWithSeeds(UserMapper $userMapper, RentalObjectMapper $rentalObjectMapper){
      $this->databaseMapper->insertSeeds($userMapper, $rentalObjectMapper);
   }
}