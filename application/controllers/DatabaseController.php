<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:58
 */

namespace Rentatool\Application\Controllers;


use Rentatool\Application\ENFramework\Factories\DatabaseConnectionFactory;
use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\ResponseFactory;
use Rentatool\Application\ENFramework\Models\DatabaseConnection;
use Rentatool\Application\ENFramework\Models\Request;
use Rentatool\Application\Mappers\RentalObjectMapper;
use Rentatool\Application\Mappers\UserGroupConnectionMapper;
use Rentatool\Application\Mappers\TimeUnitMapper;
use Rentatool\Application\Mappers\UserGroupMapper;
use Rentatool\Application\Mappers\UserMapper;
use Rentatool\Application\Services\DatabaseService;

class DatabaseController{

   /**
    * @var \Rentatool\Application\Services\DatabaseService
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
      $databaseConnection = new DatabaseConnection($databaseConnectionFactory);
      $rentalObjectMapper = new RentalObjectMapper($databaseConnection);
      $userMapper         = new UserMapper($databaseConnection);
      $userGroupMapper    = new UserGroupMapper($databaseConnection);
      $userGroupConnectionMapper = new UserGroupConnectionMapper($databaseConnection);
      $timeUnitMapper            = new TimeUnitMapper($databaseConnection);
      $this->databaseService->insertSeeds($userMapper, $rentalObjectMapper, $userGroupMapper, 
                                          $userGroupConnectionMapper, $timeUnitMapper);
      $this->response->addNotifier(['message' => 'Databas med demodata har skapats.']);

      return $this->response;
   }
}