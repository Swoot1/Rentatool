<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 22:39
 */

namespace Application\ENFramework\ErrorHandling;


use Application\ENFramework\Collections\ValueValidationCollection;
use Application\ENFramework\Models\GeneralModel;

class ErrorTrace extends GeneralModel{

   protected $message;
   protected $file;
   protected $line;
   protected $trace;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }
}
