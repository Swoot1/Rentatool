<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:13
 */

namespace Application\ENFramework\Response;

use Application\ENFramework\Validation\Collections\ValueValidationCollection;
use Application\ENFramework\Models\GeneralModel;
use Application\ENFramework\Response\Models\Notifier;

class Metadata extends GeneralModel implements IMetadata{
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