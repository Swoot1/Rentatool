<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 22:39
 */

namespace Application\PHPFramework\ErrorHandling;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Models\GeneralModel;

class ErrorTrace extends GeneralModel{

   protected $message;
   protected $file;
   protected $line;
   protected $trace;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }
}
