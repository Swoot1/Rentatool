<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:59
 */

namespace Application\Mappers;

use Application\PHPFramework\Database\Models\DatabaseConnection;

class DatabaseMapper{

   private $databaseConnection;

   private $createDatabaseSQL = "
      CREATE DATABASE IF NOT EXISTS rentatool
            DEFAULT CHARACTER SET utf8
            DEFAULT COLLATE utf8_general_ci;
   ";

   private $createTableSQL = "
      CREATE TABLE IF NOT EXISTS users(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         username VARCHAR(50) NOT NULL UNIQUE,
         email VARCHAR(64) NOT NULL UNIQUE,
         password VARCHAR(60) NOT NULL,
         administrative_access TINYINT(1) NOT NULL,
         has_confirmed_email TINYINT(1) DEFAULT 0 NOT NULL
      );

      CREATE TABLE IF NOT EXISTS reset_passwords(
        id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        user_id INTEGER NOT NULL,
        expiration_timestamp TIMESTAMP NOT NULL,
        reset_code VARCHAR(13) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_objects(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         user_id INTEGER NOT NULL,
         name VARCHAR(30) NOT NULL,
         CONSTRAINT rental_object_owner_fk FOREIGN KEY (user_id) REFERENCES users(id),
         price_per_day FLOAT NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rent_periods(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         rental_object_id INTEGER NOT NULL,
         renter_id INTEGER NOT NULL,
         from_date DATETIME NOT NULL,
         to_date DATETIME NOT NULL,
         price_per_day FLOAT NOT NULL,
         CONSTRAINT rent_period_has_a_rental_object_fk FOREIGN KEY (rental_object_id) REFERENCES rental_objects(id),
         CONSTRAINT renter_fk FOREIGN KEY (renter_id) REFERENCES users(id)
      );

      CREATE TABLE IF NOT EXISTS files(
       id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
       file_size INTEGER NOT NULL,
       file_type VARCHAR(30) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_object_file_dependencies(
        id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        rental_object_id INTEGER NOT NULL,
        file_id INTEGER NOT NULL,
        CONSTRAINT connected_to_rental_object_fk FOREIGN KEY(rental_object_id) REFERENCES rental_objects(id) ON DELETE CASCADE,
        CONSTRAINT connected_to_file_fk FOREIGN KEY(file_id) REFERENCES files(id) ON DELETE CASCADE
      );
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
    */
   public function insertSeeds(UserMapper $userMapper, RentalObjectMapper $rentalObjectMapper){
      $users = array(
         array(
            'username'                => 'andy',
            'email'                   => 'andy@andy.se',
            'password'                => '$2y$10$PwZXV0Rt0y013zL3oPxdUOComVYuspqPX/k2C6Da7dXFKdQc0qapS',
            'hasAdministrativeAccess' => true
         ),
         array(
            'username'                => 'elin',
            'email'                   => 'elin@elin.se',
            'password'                => '$2y$10$e5WdvQNzLGiR4AmU1qm/BupgIKxM1OQgfCS3nm7KVyIzaqq9P0lwK',
            'hasAdministrativeAccess' => true
         )
      );

      foreach ($users as $userData){
         $userMapper->create($userData);
      }

      $rentalObjects = array(
         array(
            'name'        => 'Stiga gräsklippare',
            'userId'      => 1,
            'pricePerDay' => 100
         ),
         array(
            'name'        => 'Hästtransport',
            'userId'      => 1,
            'pricePerDay' => 100
         ),
         array(
            'name'        => 'Slagborr',
            'userId'      => 1,
            'pricePerDay' => 100
         ),
         array(
            'name'        => 'Slipmaskin',
            'userId'      => 2,
            'pricePerDay' => 100
         ),
         array(
            'name'        => 'Utemöbler',
            'userId'      => 2,
            'pricePerDay' => 100
         ),
         array(
            'name'        => 'Tvätthall',
            'userId'      => 2,
            'pricePerDay' => 100
         )
      );

      foreach ($rentalObjects as $rentalObjectData){
         $rentalObjectMapper->create($rentalObjectData);
      }
   }
} 