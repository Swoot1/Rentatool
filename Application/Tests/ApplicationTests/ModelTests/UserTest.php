<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-18
 * Time: 07:12
 */

namespace Tests\ModelTests;

class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testPasswordHash()
    {
        $data = array(
            'username' => 'Swoot',
            'email' => 'mymail@mail.com',
            'password' => 'Sommar123'
        );


    }
} 