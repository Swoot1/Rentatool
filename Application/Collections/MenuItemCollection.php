<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Collections;


use Application\PHPFramework\Collections\GeneralCollection;

class MenuItemCollection extends GeneralCollection{
   protected $model = 'Application\Models\MenuItem';
}
