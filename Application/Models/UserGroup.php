<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:55
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;

use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Helpers\Validation\AlphaNumericValidation;
use Application\ENFramework\Helpers\Validation\BooleanValidation;
use Application\ENFramework\Helpers\Validation\IntegerValidation;
use Application\ENFramework\Helpers\Validation\TextValidation;
use Application\ENFramework\Models\GeneralModel;
use Application\Collections\UserCollection;

class UserGroup extends GeneralModel{

   protected $id;
   protected $name;
   protected $description;
   protected $members;
   protected $administrativeAccess;

   public function __construct(array $data) {
      parent::__construct($data);
      $this->setNoDBProperties(array(
                                    'members'
                               ));
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                              new IntegerValidation(array(
                                                                                         'genericName'  => 'Id',
                                                                                         'propertyName' => 'id'
                                                                                    )),
                                                              new AlphaNumericValidation(array(
                                                                                              'genericName'  => 'Gruppnamn',
                                                                                              'propertyName' => 'name',
                                                                                              'maxLength'    => 30
                                                                                         )),
                                                              new TextValidation(array(
                                                                                      'genericName'  => 'Beskrivning',
                                                                                      'propertyName' => 'description',
                                                                                      'maxLength'    => 200
                                                                                 )),
                                                              new BooleanValidation(array(
                                                                                      'genericName'  => 'Administrativ åtkomst',
                                                                                      'propertyName' => 'administrativeAccess',
                                                                                 ))
                                                         )));

   }

   public function hasAdministrativeAccess() {
      return $this->administrativeAccess === true;
   }

   public function getName() {
      return $this->name;
   }

   public function getId(){
      return $this->id;
   }

   public function setMembers(UserCollection $members) {
      $this->members = $members;
   }
}