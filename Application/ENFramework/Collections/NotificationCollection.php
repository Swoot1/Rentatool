<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:15
 */

namespace Rentatool\Application\ENFramework\Collections;


use Rentatool\Application\ENFramework\Helpers\Interfaces\INotificationCollection;
use Rentatool\Application\ENFramework\Helpers\Notifier;

class NotificationCollection extends GeneralCollection implements INotificationCollection{
   protected $data = array();
   protected $model = 'Rentatool\Application\ENFramework\Helpers\Models\Notification';

   /**
    * @param Notifier $notifier
    * @return $this
    */
   public function addNotifier(Notifier $notifier){
      $this->data[] = $notifier;

      return $this;
   }
} 