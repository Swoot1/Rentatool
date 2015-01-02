<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 02/01/15
 * Time: 17:32
 */

namespace Application\Collections;


use Application\PHPFramework\Collections\GeneralCollection;

class BookingCollection extends GeneralCollection{
   protected $model = 'Application\Models\Booking';
}