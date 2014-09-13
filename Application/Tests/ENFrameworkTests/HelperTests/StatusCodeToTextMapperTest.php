<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 09:07
 */

namespace Tests\ENFrameworkTests\HelperTests;


use Application\ENFramework\Helpers\StatusCodeToTextMapper;

class StatusCodeToTextMapperTest extends \PHPUnit_Framework_TestCase {

   public function testGetResponseCodeText() {
      $statusCodeToTextMapper = new StatusCodeToTextMapper();

      $this->assertEquals('OK', $statusCodeToTextMapper->getResponseCodeText(200));
   }

   /**
    *
    * @expectedException \Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Okänd http status code "600".
    */
   public function testGetNoneExistingResponseCodeText() {
      $statusCodeToTextMapper = new StatusCodeToTextMapper();
      $statusCodeToTextMapper->getResponseCodeText(600);
   }
} 