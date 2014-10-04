<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-04
 * Time: 16:21
 * To change this template use File | Settings | File Templates.
 */

use Application\ENFramework\Database\Factories\DatabaseConnectionFactory;
use Application\ENFramework\Database\Models\PDOContainer;

class PDOContainerTest extends PHPUnit_Framework_TestCase{

   public function testGeneratePDOSingleton(){
      $databaseConnectionFactory = new DatabaseConnectionFactory();

      $firstPDO  = $databaseConnectionFactory->build();
      $secondPDO = $databaseConnectionFactory->build();

      $this->assertTrue($firstPDO === $secondPDO, 'Same instance of PDO was fetched');
   }

}
