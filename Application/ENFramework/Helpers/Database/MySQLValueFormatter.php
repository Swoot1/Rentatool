<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 23/08/14
 * Time: 15:23
 */

namespace Application\ENFramework\Helpers\Database;

class MySQLValueFormatter implements IMySQLValueFormatter{

   public function formatValue($value, $stmt, $columnMeta){

      if (is_array($value)){
         $value = $this->formatRow($value, $stmt);
      } else{
         $value = $this->parseValue($value, $columnMeta);
      }

      return $value;
   }

   private function formatRow($row, $stmt){
      $k = 0;
      foreach ($row as $key => $column){
         $row[$key] = $this->formatValue($column, $stmt, $stmt->getColumnMeta($k)); // getColumnMeta() is experimental and may change in a future release of php.
         $k++;
      }

      return $row;
   }

   /**
    * Since mySQL only returns string the values has to be cast to their proper type.
    * I.e. $value integer '1' will return 1.
    * @param $value
    * @param array $columnMeta
    * @return string
    */
   private function parseValue($value, array $columnMeta){
      $dataType = $this->getDataTypeFromColumnMeta($columnMeta);

      if ($dataType !== 'string' && is_string($value)){
         settype($value, $dataType);
      }

      return $value;
   }

   /**
    * Return the php type that the database type represents.
    * @param array $columnMeta
    * @return string
    */
   private function getDataTypeFromColumnMeta(array $columnMeta){

      $nativeType = $columnMeta['native_type'];
      $typeMap    = array(
         'LONG'       => 'int',
         'TINY'       => 'bool',
         'VAR_STRING' => 'string',
         'FLOAT'      => 'float'
      );

      return array_key_exists($nativeType, $typeMap) ? $typeMap[$nativeType] : 'string';
   }
} 