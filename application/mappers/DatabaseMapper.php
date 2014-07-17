<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:59
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\DatabaseConnection;

class DatabaseMapper {

   private $databaseConnection;

   private $createTableSQL = "
      CREATE TABLE IF NOT EXISTS user(
          id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
          username VARCHAR(50) NOT NULL UNIQUE,
          email VARCHAR(50) NOT NULL UNIQUE,
          password CHAR(60) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS category(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         name VARCHAR(30) NOT NULL UNIQUE,
         description VARCHAR(140) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_object(
        id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        name VARCHAR(30) NOT NULL,
        available TINYINT DEFAULT 1 NOT NULL
      );
   ";

   public function __construct(DatabaseConnection $databaseConnection) {
      $this->databaseConnection = $databaseConnection;
   }

   public function create() {
      $this->databaseConnection->runQuery($this->createTableSQL);
   }
} 