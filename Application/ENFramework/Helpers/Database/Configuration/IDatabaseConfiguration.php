<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 28/09/14
 * Time: 21:41
 */

namespace Application\ENFramework\Helpers\Database\Configuration;


interface IDatabaseConfiguration {
   static function getPDOOptions();
} 