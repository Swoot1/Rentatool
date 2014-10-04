<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-13
 * Time: 14:06
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests;

use Application\ENFramework\JsonParser;

class JsonParserTest extends \PHPUnit_Framework_TestCase{

   /** @var JsonParser */
   private $jsonParser;

   public function setUp(){
      $this->jsonParser = new JsonParser();
   }

   public function testValidJson(){
      $validJson = [
         '{}',
         '{"key": "value"}',
         '{"key": "value", "nested": {"nestedKey": "nestedValue"}}'
      ];

      $expectedParsedData = [
         [],
         ['key' => 'value'],
         ['key' => 'value', 'nested' => ['nestedKey' => 'nestedValue']]
      ];

      for ($i = 0; $i < count($validJson); $i++){
         $parsedData = $this->jsonParser->parse($validJson[$i]);
         $this->assertEquals($expectedParsedData[$i], $parsedData);
         $i++;
      }
   }

   public function testEmptyValue(){
      $invalidJson = '';
      $parsedData  = $this->jsonParser->parse($invalidJson);
      $this->assertEquals([], $parsedData);
   }

   public function testNullValue(){
      $invalidJson = null;
      $parsedData  = $this->jsonParser->parse($invalidJson);
      $this->assertEquals([], $parsedData);
   }

   /**
    * @expectedException        \Application\ENFramework\ErrorHandling\Exceptions\BadJsonException
    * @expectedExceptionMessage Ogiltig JSON: Ogiltigt format
    */
   public function testSingleQuotes(){
      $invalidJson = "{'key': 'value'}";
      $this->jsonParser->parse($invalidJson);
   }

   /**
    * @expectedException        \Application\ENFramework\ErrorHandling\Exceptions\BadJsonException
    * @expectedExceptionMessage Ogiltig JSON: Ogiltigt format
    */
   public function testInvalidSyntax(){
      $invalidJson = '{"json": }';
      $this->jsonParser->parse($invalidJson);
   }

   /**
    * @expectedException        \Application\ENFramework\ErrorHandling\Exceptions\BadJsonException
    * @expectedExceptionMessage Ogiltig JSON: Ogiltig encoding
    */
   public function testInvalidUTF8Encoding(){
      $invalidJson = utf8_decode('{"käy": "Det snöar i umeå ! :)"}');
      $this->jsonParser->parse($invalidJson);
   }

}
