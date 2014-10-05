<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 15:44
 * To change this template use File | Settings | File Templates.
 */

use Application\PHPFramework\Response\Models\Notifier;

class NotifierTest extends PHPUnit_Framework_TestCase{

   public function testDefaultNotifierType(){
      $notifier = new Notifier(['message' => 'Testing notifiers']);
      $notifier = $notifier->toArray();

      $this->assertEquals(Notifier::SUCCESS, $notifier['type']);
   }

}