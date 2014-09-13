<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 17:35
 */

namespace Application\ENFramework\Helpers\Interfaces;


use Application\ENFramework\Helpers\Notifier;

interface IMetadata{
   public function addNotifier(Notifier $notifier);

   public function toArray();
} 