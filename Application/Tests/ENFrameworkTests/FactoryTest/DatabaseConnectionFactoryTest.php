<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 03/10/14
 * Time: 10:21
 */

namespace Tests\PHPFrameworkTests\FactoryTest;


use Application\PHPFramework\Database\Factories\DatabaseConnectionFactory;

class DatabaseConnectionFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testBuild(){
      $databaseConnectionFactory = new DatabaseConnectionFactory();
      $databaseConnection        = $databaseConnectionFactory->build();

      $this->assertTrue($databaseConnection instanceof \PDO);
   }
} 