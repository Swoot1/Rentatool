<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Application\Controllers;

use Application\PHPFramework\Database\Factories\DatabaseConnectionFactory;
use Application\PHPFramework\Database\Models\DatabaseConnection;
use Application\PHPFramework\Database\Formatters\MySQLValueFormatter;
use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Mappers\RentalObjectMapper;
use Application\Mappers\UserMapper;
use Application\Services\DatabaseService;

class DatabaseController{

   /**
    * @var \Application\Services\DatabaseService
    */
   private $databaseService;
   private $response;

   /**
    * @param DatabaseService $databaseService
    * @param ResponseFactory $responseFactory
    */
   public function __construct(DatabaseService $databaseService, ResponseFactory $responseFactory){
      $this->databaseService = $databaseService;
      $this->response = $responseFactory->build();
   }

   public function create(){
      $this->databaseService->create();
      $this->response->addNotifier(['message' => 'Databastabeller har skapats.']);

      return $this->response;
   }

   /**
    * Creates a database with dummy values.
    * @return Response
    */
   public function createWithSeeds(){
      $this->databaseService->create();

      $databaseConnectionFactory = new DatabaseConnectionFactory();
      $databaseConnection        = new DatabaseConnection($databaseConnectionFactory, new MySQLValueFormatter());
      $rentalObjectMapper        = new RentalObjectMapper($databaseConnection);
      $userMapper                = new UserMapper($databaseConnection);
      $this->databaseService->createWithSeeds($userMapper, $rentalObjectMapper);
      $this->response->addNotifier(['message' => 'Databas med demodata har skapats.']);

      return $this->response;
   }
}