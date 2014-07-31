<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:42
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests;


use Rentatool\Application\ENFramework\Helpers\ContentTypeConverter;

class ContentTypeConverterTest extends \PHPUnit_Framework_TestCase {
   public function testConvertDataToJSON() {
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

   public function testConvertDataToXML() {
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

      //Cheating this is. convertDataToXML returns LF line endings this environment runs with CRLF line endings. Compare strings after removing line endings.
      $XMLString            = preg_replace('/[\r\n]*/', '', $contentTypeConverter->convertDataToXML($data));

      $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?><root><someProperty>1</someProperty><someOtherProperty>value</someOtherProperty><myCollection><item0><property1>42</property1><property2>value</property2></item0></myCollection></root>', $XMLString);
   }
} 