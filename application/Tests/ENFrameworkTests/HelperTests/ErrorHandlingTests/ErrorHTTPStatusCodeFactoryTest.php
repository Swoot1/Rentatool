<?php
/**
 * User: Elin
 * Date: 2014-07-07
 * Time: 11:21
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\ErrorHTTPStatusCodeFactory;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NoSuchRouteException;

class ErrorHeaderFactoryTest extends \PHPUnit_Framework_TestCase{

    /**
     * Test that 404 the status code for not found is returned when a noSuchRouteException is thrown.
     */
    public function testGetHeaderWithNoSuchRoute()
    {
        $noSuchRouteException = new NoSuchRouteException('');
        $errorHeaderFactory = new ErrorHTTPStatusCodeFactory($noSuchRouteException);
        $this->assertEquals(404, $errorHeaderFactory->getHTTPStatusCode());
    }

    /**
     * Test that 500 the status code for internal server error is returned when a regular exception is thrown.
     */
    public function testGetHeaderWithUncaughtException()
    {
        $exception = new \Exception('');
        $errorHeaderFactory = new ErrorHTTPStatusCodeFactory($exception);
        $this->assertEquals(500, $errorHeaderFactory->getHTTPStatusCode());
    }

    /**
     * Test that 200 the status code for OK is returned when an applicationException is thrown.
     */
    public function testGetHeaderWithApplicationException()
    {
        $applicationException = new ApplicationException('');
        $errorHeaderFactory = new ErrorHTTPStatusCodeFactory($applicationException);
        $this->assertEquals(403, $errorHeaderFactory->getHTTPStatusCode());
    }

} 