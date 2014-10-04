<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 18:02
 */

namespace Application\Models;


use Application\ENFramework\Validation\Collections\ValueValidationCollection;
use Application\ENFramework\Models\GeneralModel;

class File extends GeneralModel{

   protected $id;
   protected $fileType;
   protected $fileSize;

   public function getId(){
      return $this->id;
   }

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(array());
   }
}