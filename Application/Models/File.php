<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 18:02
 */

namespace Application\Models;


use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Validation\MapValidation;

class File extends GeneralModel{

   protected $id;
   protected $fileType;
   protected $fileSize;
   protected $fileExtension;

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
                                                                                         'upperLimit'   => 100000000
                                                                                    )),
                                                              new MapValidation(array(
                                                                                     'map'          => array('image/jpeg'),
                                                                                     'genericName'  => 'filtyp',
                                                                                     'propertyName' => 'fileType'
                                                                                )),
                                                              new AlphaNumericValidation(array(
                                                                                              'genericName'  => 'filändelse',
                                                                                              'propertyName' => 'fileExtension'
                                                                                         ))
                                                         ));
   }
}