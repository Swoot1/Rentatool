<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-18
 * Time: 08:28
 */
namespace Application\PHPFramework\Database\Models;

interface IDatabaseConnection{
   public function runQuery($query, $params = array());
}