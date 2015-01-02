<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:44
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;

use Application\Collections\FileCollection;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Validation\TextValidation;
use Application\PHPFramework\Models\GeneralModel;

class RentalObject extends GeneralModel{
   protected $id;
   protected $userId;
   protected $name;
   protected $description;
   protected $pricePerDay;
   protected $fileCollection;
   protected $active = true;
   protected $_setters = array(
      'fileCollection' => 'setFileCollection'
   );

   public function __construct(array $data = array()){
      parent::__construct($data);
      $this->_noDBProperties = array('fileCollection');

      return $this;
   }

   /**
    * Sets the type and length validation on all properties.
    * @return $this
    */
   protected function setUpValidation(){
      $validation = new ValueValidationCollection(array(
                                                     new IntegerValidation(array(
                                                                              'genericName'  => 'uthyrningsobjektets id',
                                                                              'propertyName' => 'id'
                                                                           )
                                                     ),
                                                     new IntegerValidation(array(
                                                                              'genericName'  => 'uthyrningsobjektets användarid',
                                                                              'propertyName' => 'userId'
                                                                           )
                                                     ),
                                                     new TextValidation(array(
                                                                           'genericName'  => 'uthyrningsobjektets namn',
                                                                           'propertyName' => 'name',
                                                                           'maxLength'    => 30
                                                                        )
                                                     ),
                                                     new TextValidation(array(
                                                                           'genericName'  => 'beskrivning',
                                                                           'propertyName' => 'description',
                                                                           'maxLength'    => 3000
                                                                        )
                                                     )
                                                  ));
      $this->setValidation($validation);

      return $this;
   }

   /**
    * @param $data
    * @return $this
    */
   public function setFileCollection($data){

      if ($data instanceof FileCollection){
         $this->fileCollection = $data;
      } else{
         $this->fileCollection = new FileCollection($data);
      }

      return $this;
   }

   public function getId(){
      return $this->id;
   }

   public function getFileCollection(){
      return $this->fileCollection;
   }

   public function isOwner(User $user){
      return $user->getId() === $this->userId;
   }

   public function getPricePerDay(){
      return $this->pricePerDay;
   }

   public function getUserId(){
      return $this->userId;
   }

   public function getName(){
      return $this->name;
   }
}