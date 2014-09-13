<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-19
 * Time: 18:53
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Models\GeneralModel;

class UserGroupConnection extends GeneralModel{

   protected $groupId;
   protected $userId;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                              new IntegerValidation(array(
                                                                                         'genericName'  => 'Grupp-id',
                                                                                         'propertyName' => 'groupId'
                                                                                    )),
                                                              new IntegerValidation(array(
                                                                                         'genericName'  => 'Användar-id',
                                                                                         'propertyName' => 'userId'
                                                                                    ))
                                                         )));
   }


   public function getUserId() {
      return $this->userId;
   }


   public function getGroupId() {
      return $this->groupId;
   }
}