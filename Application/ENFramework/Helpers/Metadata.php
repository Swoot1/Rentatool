<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:13
 */

namespace Application\ENFramework\Helpers;


use Application\ENFramework\Collections\NotificationCollection;
use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Interfaces\IMetadata;
use Application\ENFramework\Helpers\Interfaces\INotificationCollection;
use Application\ENFramework\Models\GeneralModel;

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