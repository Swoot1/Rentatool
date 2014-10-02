<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:28
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\AlphaNumericValidation;
use Application\ENFramework\Helpers\Validation\DateTimeValidation;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Models\GeneralModel;

class ResetPassword extends GeneralModel{

   protected $id;
   protected $userId;
   protected $resetCode;
   protected $expirationTimestamp;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'id',
                                                                                     'propertyName' => 'id'
                                                                                  )),
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'användarid',
                                                                                     'propertyName' => 'userId'
                                                                                  )),
                                                            new AlphaNumericValidation(array(
                                                                                          'genericName'  => 'återställningskod',
                                                                                          'propertyName' => 'resetCode'
                                                                                       )),
                                                            new DateTimeValidation(array(
                                                                                      'genericName'  => 'tidsstämpel',
                                                                                      'propertyName' => 'expirationTimestamp'
                                                                                   )),

                                                         )));
   }

   public function getResetCode(){
      return $this->resetCode;
   }

   public function getId(){
      return $this->id;
   }

   public function getUserId(){
      return $this->userId;
   }
}