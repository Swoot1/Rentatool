<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:13
 */

namespace Application\PHPFramework\Response;

use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Response\Models\Notifier;

class Metadata extends GeneralModel implements IMetadata{
   protected $notificationCollection;

   public function __construct(INotificationCollection $notificationCollection){
      $this->notificationCollection = $notificationCollection;
      parent::__construct();
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }

   public function addNotifier(Notifier $notifier){

      $this->notificationCollection->addNotifier($notifier);

      return $this;
   }
} 