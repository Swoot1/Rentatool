<?php
   /**
    * User: Elin
    * Date: 2014-07-17
    * Time: 18:58
    */

   namespace Rentatool\Application\Controllers;


   use Rentatool\Application\ENFramework\Helpers\Response;
   use Rentatool\Application\Services\DatabaseService;

   class DatabaseController {

      private $databaseService;

      public function __construct(DatabaseService $databaseService) {
         $this->databaseService = $databaseService;
      }

      public function create() {
         $this->databaseService->create();
         return new Response();
      }
   }