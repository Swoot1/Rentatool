<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 23/08/14
 * Time: 15:24
 */

namespace Application\ENFramework\Database;


interface IMySQLValueFormatter{
   public function formatValue($value, $stmt, $columnMeta);
} 