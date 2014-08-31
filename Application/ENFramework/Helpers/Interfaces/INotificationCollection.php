<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 12:52
 */

namespace Rentatool\Application\ENFramework\Helpers\Interfaces;


use Rentatool\Application\ENFramework\Helpers\Notifier;

interface INotificationCollection{

   public function addNotifier(Notifier $notifier);

   public function toArray();
} 