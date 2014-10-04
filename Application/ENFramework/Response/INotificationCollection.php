<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 12:52
 */

namespace Application\ENFramework\Response;

use Application\ENFramework\Response\Models\Notifier;

interface INotificationCollection{

   public function addNotifier(Notifier $notifier);

   public function toArray();
} 