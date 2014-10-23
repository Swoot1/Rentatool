<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 18:02
 */

namespace Application\Models;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Validation\MapValidation;

class File extends GeneralModel{

   protected $id;
   protected $fileType;
   protected $fileSize;

   public function getId(){
      return $this->id;
   }

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(array(
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'användarid',
                                                                                     'propertyName' => 'id'
                                                                                  )),
                                                            new IntegerValidation(array(
                                                                                     'genericName'  => 'filstorlek',
                                                                                     'propertyName' => 'fileSize',
                                                                                     'lowerLimit'   => 1000,
                                                                                     'upperLimit'   => 10000000 // TODO might be a bit to small
                                                                                  )),

                                                            new MapValidation(array(
                                                                                 'map'          => array('image/jpeg'), // TODO add more file types that we want to support.
                                                                                 'genericName'  => 'filtyp',
                                                                                 'propertyName' => 'fileType'
                                                                              ))
                                                         ));
   }
}