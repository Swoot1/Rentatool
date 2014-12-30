<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-12-30
 * Time: 20:36
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\EmailValidation;
use Application\PHPFramework\Validation\TextValidation;

class RentalNotification extends GeneralModel {

   protected $rentalObjectName;
   protected $renterEmail;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                              new EmailValidation(array(
                                                                                         'genericName'  => 'Uthyrarens e-post',
                                                                                         'propertyName' => 'renterEmail'
                                                                                    )),
                                                              new TextValidation(array(
                                                                                         'genericName'  => 'Uthyrningsobjekt',
                                                                                         'propertyName' => 'rentalObjectName'
                                                                                    ))
                                                         )));
   }

   public function getRenterEmail() {
      return $this->renterEmail;
   }

   public function getRentalObjectName() {
      return $this->rentalObjectName;
   }

}