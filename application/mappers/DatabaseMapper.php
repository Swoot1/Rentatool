<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:59
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\DatabaseConnection;

class DatabaseMapper{

   private $databaseConnection;

   private $createDatabaseSQL = "
      CREATE DATABASE IF NOT EXISTS rentatool
            DEFAULT CHARACTER SET utf8
            DEFAULT COLLATE utf8_general_ci;
   ";

   private $createTableSQL = "
      CREATE TABLE IF NOT EXISTS user(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         username VARCHAR(50) NOT NULL UNIQUE,
         email VARCHAR(64) NOT NULL UNIQUE,
         password VARCHAR(60) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS category(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         name VARCHAR(30) NOT NULL UNIQUE,
         description VARCHAR(140) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_object(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         user_id INTEGER NOT NULL,
         CONSTRAINT owner FOREIGN KEY (user_id) REFERENCES user(id),
         name VARCHAR(30) NOT NULL,
         available BOOLEAN DEFAULT true NOT NULL
      );

      CREATE TABLE IF NOT EXISTS user_groups (
         id  INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         name VARCHAR(30) NOT NULL UNIQUE,
         description varchar(200) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS users_groups_maps (
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         user_id INTEGER NOT NULL,
         group_id INTEGER NOT NULL,
         CONSTRAINT user_group_maps_user_fk FOREIGN KEY (user_id) REFERENCES user(id),
         CONSTRAINT user_group_maps_group_fk FOREIGN KEY (group_id) REFERENCES user_groups(id)
      );

      CREATE TABLE IF NOT EXISTS rent_period(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         rental_object_id INTEGER NOT NULL,
         CONSTRAINT rental_object FOREIGN KEY (rental_object_id) REFERENCES rental_object(id),
         renter_id INTEGER NOT NULL,
         CONSTRAINT renter FOREIGN KEY (renter_id) REFERENCES user(id),
         from_date DATETIME NOT NULL,
         to_date DATETIME NOT NULL
      );

      CREATE TABLE IF NOT EXISTS time_unit(
       id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
       name varchar(30) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS price_plan(
       id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
       rental_object_id INTEGER NOT NULL,
       time_unit_id INTEGER NOT NULL,
       price FLOAT NOT NULL,
       CONSTRAINT rental_object_id FOREIGN KEY (rental_object_id) REFERENCES rental_object(id) ON DELETE CASCADE,
       CONSTRAINT time_unit_id FOREIGN KEY (time_unit_id) REFERENCES time_unit(id),
       CONSTRAINT unique_price_plan UNIQUE (rental_object_id, time_unit_id)
      )
   ";

   public function __construct(DatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function createDatabase(){
      $host     = 'localhost';
      $username = 'root';
      $password = '';

      $PDOOptions         = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, \PDO::MYSQL_ATTR_FOUND_ROWS => true);
      $databaseConnection = new \PDO(sprintf('mysql:host=%s;', $host), $username, $password, $PDOOptions);

      $databaseConnection->exec($this->createDatabaseSQL);
   }

   public function createTables(){
      $this->databaseConnection->runQuery($this->createTableSQL);
   }

   /**
    * Insert seed values so that you don't have to start with an empty db.
    * @param UserMapper $userMapper
    * @param RentalObjectMapper $rentalObjectMapper
    * @param UserGroupMapper $userGroupMapper
    * @param TimeUnitMapper $timeUnitMapper
    */
   public function insertSeeds(UserMapper $userMapper, RentalObjectMapper $rentalObjectMapper, UserGroupMapper $userGroupMapper,
                               TimeUnitMapper $timeUnitMapper){
      $users = array(
         array(
            'username' => 'andy',
            'email'    => 'andy@andy.se',
            'password' => '$2y$10$PwZXV0Rt0y013zL3oPxdUOComVYuspqPX/k2C6Da7dXFKdQc0qapS'
         ),
         array(
            'username' => 'elin',
            'email'    => 'elin@elin.se',
            'password' => '$2y$10$e5WdvQNzLGiR4AmU1qm/BupgIKxM1OQgfCS3nm7KVyIzaqq9P0lwK'
         )
      );

      foreach ($users as $userData){
         $userMapper->create($userData);
      }

      $rentalObjects = array(
         array(
            'name'      => 'Stiga gräsklippare',
            'userId'    => 1,
            'available' => 1
         ),
         array(
            'name'      => 'Hästtransport',
            'userId'    => 1,
            'available' => 1
         ),
         array(
            'name'      => 'Slagborr',
            'userId'    => 1,
            'available' => 0
         ),
         array(
            'name'      => 'Slipmaskin',
            'userId'    => 2,
            'available' => 1
         ),
         array(
            'name'      => 'Utemöbler',
            'userId'    => 2,
            'available' => 1
         ),
         array(
            'name'      => 'Tvätthall',
            'userId'    => 2,
            'available' => 0
         )
      );

      foreach ($rentalObjects as $rentalObjectData){
         $rentalObjectMapper->create($rentalObjectData);
      }

      $userGroups = array(
         array(
            'name'        => 'administrators',
            'description' => 'They have the power'
         ),
         array(
            'name'        => 'users',
            'description' => 'They bring the money'
         )
      );

      foreach ($userGroups as $userGroup){
         $userGroupMapper->create($userGroup);
      }

      $timeUnits = array(
         array(
            'name' => 'timme',
         ),
         array(
            'name' => 'dag'
         ),
         array(
            'name' => 'kalendermånad'
         ),
         array(
            'name' => 'år'
         )
      );

      foreach ($timeUnits as $timeUnit){
         $timeUnitMapper->create($timeUnit);
      }
   }
} 