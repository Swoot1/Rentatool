<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 19/01/15
 * Time: 09:19
 */

namespace Application\PHPFramework;


interface IPagination{


   public function getPaginatedQuery($query);

   public function getRowCountQuery($query);


   public function setRowCount($rowCount);

   public function getRowCount();

   public function getPaginationParameters();

}