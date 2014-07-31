<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 09:07
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests;


use Rentatool\Application\ENFramework\Helpers\StatusCodeToTextMapper;

class StatusCodeToTextMapperTest extends \PHPUnit_Framework_TestCase {

   public function testGetResponseCodeText() {
      $statusCodeToTextMapper = new StatusCodeToTextMapper();

      $this->assertEquals('OK', $statusCodeToTextMapper->getResponseCodeText(200));
   }

   /**
    *
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Okänd http status code "600".
    */
   public function testGetNoneExistingResponseCodeText() {
      $statusCodeToTextMapper = new StatusCodeToTextMapper();
      $statusCodeToTextMapper->getResponseCodeText(600);
   }
} 