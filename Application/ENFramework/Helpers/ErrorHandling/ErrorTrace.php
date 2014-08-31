<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 22:39
 */

namespace Rentatool\Application\ENFramework\Helpers\ErrorHandling;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class ErrorTrace extends GeneralModel{

   protected $message;
   protected $file;
   protected $line;
   protected $trace;

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection());
   }
}
