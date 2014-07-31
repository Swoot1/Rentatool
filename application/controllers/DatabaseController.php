<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\DatabaseConnection;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Mappers\UserMapper;
use Rentatool\Application\Services\DatabaseService;

class DatabaseController {

   /**
    * @var \Rentatool\Application\Services\DatabaseService
    */
   private $databaseService;

   public function __construct(DatabaseService $databaseService) {
      $this->databaseService = $databaseService;
   }

   public function create() {
      $this->databaseService->create();
      $responseFactory = new ResponseFactory();

      return $responseFactory->createResponse();
   }

   /**
    * Creates a database with dummy values.
    * @return Response
    */
   public function createWithSeeds() {
      $this->databaseService->create();

      $databaseConnection = new DatabaseConnection();
      $rentalObjectMapper = new RentalObjectMapper($databaseConnection);
      $userMapper         = new UserMapper($databaseConnection);
      $this->databaseService->insertSeeds($userMapper, $rentalObjectMapper);

      $responseFactory = new ResponseFactory();
      return $responseFactory->createResponse();
   }
}