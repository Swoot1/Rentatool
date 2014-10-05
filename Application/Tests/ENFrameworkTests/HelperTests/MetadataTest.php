<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 15:50
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Tests\PHPFrameworkTests\HelperTests;


use Application\PHPFramework\Response\Metadata;
use Application\PHPFramework\Response\Models\Notifier;
use Application\PHPFramework\Response\NotificationCollection;

class MetadataTest extends \PHPUnit_Framework_TestCase{

   public function testAddNotifier(){
      $notifierCollection = new NotificationCollection();
      $metadata           = new Metadata($notifierCollection);
      $notifier           = new Notifier(['message' => 'Testing metadata']);

      $metadata->addNotifier($notifier);
      $metaDataArray = $metadata->toArray();

      $this->assertCount(1, $metaDataArray['notificationCollection']);
   }

}