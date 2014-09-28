<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 28/09/14
 * Time: 22:58
 */

namespace Application\Models;

use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Models\GeneralModel;

class IndexHTML extends GeneralModel{

   protected $content;

   public function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array()
      );
   }

   public function toArray(){
      return $this->content;
   }
} 