<?php
   /**
    * User: Elin
    * Date: 2014-07-17
    * Time: 18:58
    */

   namespace Rentatool\Application\Services;

   use Rentatool\Application\Mappers\DatabaseMapper;

   class DatabaseService {

      protected $databaseMapper;

      public function __construct(DatabaseMapper $databaseMapper) {
         $this->databaseMapper = $databaseMapper;
      }

      public function create() {
         $this->databaseMapper->create();
      }
   }