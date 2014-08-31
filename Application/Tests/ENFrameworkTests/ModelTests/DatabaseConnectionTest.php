<?php
/**
 * User: Elin
 * Date: 2014-07-29
 * Time: 16:03
 */

namespace Rentatool\Tests\ENFrameworkTests\ModelTests;


use Rentatool\Application\ENFramework\Models\DatabaseConnection;

class DatabaseConnectionTest extends \PHPUnit_Framework_TestCase {
   public function testCastInteger() {
      $databaseConnection = new DatabaseConnection();
   }
} 