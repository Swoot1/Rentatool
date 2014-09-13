<?php
/**
 * User: Elin
 * Date: 2014-07-06
 * Time: 19:48
 */

namespace Application\ENFramework\Helpers\ErrorHandling;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ConflictException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\MethodNotAllowedException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Application\ENFramework\Helpers\ErrorHandling\Exceptions\UserIsNotAllowedException;

class ErrorHTTPStatusCodeFactory
{

    private $_exception;

    public function __construct(\Exception $exception)
    {
        $this->_exception = $exception;
    }

    public function getHTTPStatusCode()
    {
        if ($this->_exception instanceof ApplicationException) {
            $HTTPStatusCode = 403;
        } elseif ($this->_exception instanceof NoSuchRouteException || $this->_exception instanceof NotFoundException) {
            $HTTPStatusCode = 404;
        } elseif ($this->_exception instanceof ConflictException) {
            $HTTPStatusCode = 409;
        } elseif ($this->_exception instanceof MethodNotAllowedException) {
            $HTTPStatusCode = 405;
        } else if ($this->_exception instanceof UserIsNotAllowedException) {
            $HTTPStatusCode = 403;
        } else {
            $HTTPStatusCode = 500;
        }

        return $HTTPStatusCode;
    }
}