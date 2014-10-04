<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 17:35
 */

namespace Application\PHPFramework\Response;

use Application\PHPFramework\Response\Models\Notifier;

interface IMetadata{
   public function addNotifier(Notifier $notifier);

   public function toArray();
} 