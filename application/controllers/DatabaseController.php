<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Helpers\Notifier;
use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\DatabaseConnection;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Mappers\UserGroupMapper;
use Rentatool\Application\Mappers\UserMapper;
use Rentatool\Application\Services\DatabaseService;

class DatabaseController {

   /**
    * @var \Rentatool\Application\Services\DatabaseService
    */
   private $databaseService;
   private $response;

   public function __construct(DatabaseService $databaseService, ResponseFactory $responseFactory) {
      $this->databaseService = $databaseService;
      $this->response = $responseFactory->createResponse();
   }

   public function create() {
      $this->databaseService->create();
      $successNotifier = new Notifier(array('message' => 'Databastabeller har skapats.'));
      $this->response->addNotifier($successNotifier);

      return $this->response;
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
      $userGroupMapper    = new UserGroupMapper($databaseConnection);
      $this->databaseService->insertSeeds($userMapper, $rentalObjectMapper, $userGroupMapper);
      $successNotifier = new Notifier(array('message' => 'Databas med demodata har skapats.'));
      $this->response->addNotifier($successNotifier);

      return $this->response;
   }
}