<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:55
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Models;

use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\AlphaNumericValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\TextValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;
use Rentatool\Application\Collections\UserCollection;

class UserGroup extends GeneralModel{

   protected $id;
   protected $name;
   protected $description;
   protected $members;

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
                                                                                 ))
                                                         )));

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