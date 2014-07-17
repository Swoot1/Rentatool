<?php
/**
 * User: Elin
 * Date: 2014-07-09
 * Time: 10:09
 */

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ErrorException;

/**
 * Throws an exception when an error occurs i.e. when a variable is used but never defined.
 * http://stackoverflow.com/questions/841500/php-exceptions-vs-errors
 * @param $code
 * @param $message
 * @param $file
 * @param $line
 * @throws ErrorException
 */
function throwErrorException($code, $message, $file, $line)
{
    throw new ErrorException($code, $message, $file, $line);
}

set_error_handler('throwErrorException');