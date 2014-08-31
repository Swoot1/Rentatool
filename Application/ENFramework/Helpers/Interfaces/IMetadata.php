<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 17:35
 */

namespace Rentatool\Application\ENFramework\Helpers\Interfaces;


use Rentatool\Application\ENFramework\Helpers\Notifier;

interface IMetadata{
   public function addNotifier(Notifier $notifier);

   public function toArray();
} 