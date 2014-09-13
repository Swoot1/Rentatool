<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:52
 */

namespace Application\Collections;


use Application\ENFramework\Collections\GeneralCollection;

class UserCollection extends GeneralCollection{
    protected $model = 'Application\Models\User';
} 