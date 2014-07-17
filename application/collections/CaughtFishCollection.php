<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:57
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Collections;

use Rentatool\Application\ENFramework\Collections\GeneralCollection;

class CaughtFishCollection extends GeneralCollection
{
    protected $data;
    protected $model = 'Rentatool\Application\Models\CaughtFish';
}