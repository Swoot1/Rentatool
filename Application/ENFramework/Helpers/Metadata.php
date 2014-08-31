<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:13
 */

namespace Rentatool\Application\ENFramework\Helpers;


use Rentatool\Application\ENFramework\Collections\NotificationCollection;
use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Interfaces\IMetadata;
use Rentatool\Application\ENFramework\Helpers\Interfaces\INotificationCollection;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class Metadata extends GeneralModel implements IMetadata{
   /**
    * @var NotificationCollection
    */
   protected $notificationCollection;

   public function __construct(INotificationCollection $notificationCollection){
      $this->notificationCollection = $notificationCollection;
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }

   public function addNotifier(Notifier $notifier){

      $this->notificationCollection->addNotifier($notifier);

      return $this;
   }
} 