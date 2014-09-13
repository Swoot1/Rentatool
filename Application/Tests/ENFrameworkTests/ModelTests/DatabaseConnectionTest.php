<?php
/**
 * User: Elin
 * Date: 2014-07-29
 * Time: 16:03
 */

namespace Tests\ENFrameworkTests\ModelTests;


use Application\ENFramework\Models\DatabaseConnection;

class DatabaseConnectionTest extends \PHPUnit_Framework_TestCase {
   public function testCastInteger() {
      $databaseConnection = new DatabaseConnection();
   }
} 