<?php
/**
 * User: Elin
 * Date: 2014-07-08
 * Time: 21:47
 */

namespace Application\ENFramework\ErrorHandling\Exceptions;

/**
 * An exception that is thrown when a error occurs, i.e. when a variable is used but never defined.
 * Class ErrorException
 * @package Application\ENFramework\ErrorHandling\Exceptions
 */
class ErrorException extends \Exception{

   public function __construct($code, $message, $file, $line){
      parent::__construct($message, $code);

      $this->file = $file;
      $this->line = $line;
   }
} 