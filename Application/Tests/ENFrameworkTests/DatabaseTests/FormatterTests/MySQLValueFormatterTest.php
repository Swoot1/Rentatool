<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 12:14
 */

namespace Tests\PHPFrameworkTests\DatabaseTests\FormatterTests;


use Application\PHPFramework\Database\Formatters\MySQLValueFormatter;

class MySQLValueFormatterTest extends \PHPUnit_Framework_TestCase{

   public function testFormatValueToInteger(){

      $PDOStatementMock    = $this->getMockBuilder('PDOStatementMock')
                                  ->disableOriginalConstructor()
                                  ->getMock();
      $mySQLValueFormatter = new MySQLValueFormatter();
      $columnMeta          = array(
         'native_type' => 'LONG',
         'flags'       => array(
            'not_null',
            'primary_key'
         ),
         'table'       => 'rental_objects',
         'name'        => 'id',
         'len'         => 11,
         'precision'   => 1,
         'pdo_type'    => 2
      );

      $value = $mySQLValueFormatter->formatValue('14', $PDOStatementMock, $columnMeta);

      $this->assertSame(14, $value);

   }

   public function testFormatValueToFloat(){

      $PDOStatementMock    = $this->getMockBuilder('PDOStatementMock')
                                  ->disableOriginalConstructor()
                                  ->getMock();
      $mySQLValueFormatter = new MySQLValueFormatter();
      $columnMeta          = array(
         'native_type' => 'FLOAT',
         'flags'       => array(
            'not_null'
         ),
         'table'       => 'rental_objects',
         'name'        => 'pricePerDay',
         'len'         => 12,
         'precision'   => 31,
         'pdo_type'    => 2
      );

      $value = $mySQLValueFormatter->formatValue('100.2', $PDOStatementMock, $columnMeta);

      $this->assertSame(100.2, $value);

   }

}

class PDOStatementMock extends \PDOStatement{
}