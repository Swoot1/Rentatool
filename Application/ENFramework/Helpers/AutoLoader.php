<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-08
 * Time: 17:14
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Helpers;


class AutoLoader{

   public function setUpAutoLoader(){

      spl_autoload_register(function ($className){
         $className = ltrim($className, '\\');
         $fileName  = '';

         if ($lastNsPos = strrpos($className, '\\')){
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
         }

         $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

         require $fileName;
      });
   }
}