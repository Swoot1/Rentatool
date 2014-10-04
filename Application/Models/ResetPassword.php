<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:28
 */

namespace Application\Models;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\DateTimeValidation;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Models\GeneralModel;

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