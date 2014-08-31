<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:42
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests;


use Rentatool\Application\ENFramework\Helpers\ContentTypeConverter;

class ContentTypeConverterTest extends \PHPUnit_Framework_TestCase{
   public function testConvertDataToJSON(){
      $contentTypeConverter = new ContentTypeConverter();
      $data                 = array(
         'someProperty'      => 1,
         'someOtherProperty' => 'value',
         'myCollection'      => array(
            array(
               'property1' => 42,
               'property2' => 'value'
            )
         )
      );
      $JSONString           = $contentTypeConverter->convertDataToJSON($data);

      $this->assertEquals('{"someProperty":1,"someOtherProperty":"value","myCollection":[{"property1":42,"property2":"value"}]}', $JSONString);
   }
} 