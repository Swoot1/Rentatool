<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Application\Controllers;


use Application\ENFramework\Factories\DatabaseConnectionFactory;
use Application\ENFramework\Helpers\MySQLValueFormatter;
use Application\ENFramework\Helpers\Response;
use Application\ENFramework\Helpers\ResponseFactory;
use Application\ENFramework\Models\DatabaseConnection;
use Application\ENFramework\Models\Request;
use Application\Mappers\RentalObjectMapper;
use Application\Mappers\UserMapper;
use Application\Services\DatabaseService;

class DatabaseController{

   /**
    * @var \Application\Services\DatabaseService
    */
   private $request;
   private $databaseService;
   private $response;

   /**
    * @param Request $request
    * @param DatabaseService $databaseService
    * @param ResponseFactory $responseFactory
    */
   public function __construct(Request $request, DatabaseService $databaseService, ResponseFactory $responseFactory){
      $this->request         = $request;
      $this->databaseService = $databaseService;
      $this->response        = $responseFactory->createResponse();
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
      $databaseConnection = new DatabaseConnection($databaseConnectionFactory, new MySQLValueFormatter());
      $rentalObjectMapper = new RentalObjectMapper($databaseConnection);
      $userMapper         = new UserMapper($databaseConnection);
      $this->databaseService->insertSeeds($userMapper, $rentalObjectMapper);
      $this->response->addNotifier(['message' => 'Databas med demodata har skapats.']);

      return $this->response;
   }
}