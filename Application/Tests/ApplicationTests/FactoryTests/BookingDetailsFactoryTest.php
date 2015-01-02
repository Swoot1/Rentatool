<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 17:14
 */

namespace Tests\FactoryTests;


use Application\Factories\BookingDetailsFactory;
use Application\Models\RentalObject;
use Application\Models\RentPeriod;
use Application\Models\User;

class BookingDetailsFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testGetBookingDetails(){
      $bookingDetailsFactory = new BookingDetailsFactory();

      $rentPeriod        = new RentPeriod(array('fromDate' => '2014-01-01', 'toDate' => '2014-01-10', 'pricePerDay' => 20));
      $rentalObjectOwner = new User(array('username' => 'Elin'));
      $rentalObject      = new RentalObject(array('name' => 'Speedhuswagn'));

      $bookingDetails = $bookingDetailsFactory->getBookingDetails($rentPeriod, $rentalObjectOwner, $rentalObject);

      $bookingDetailsData = $bookingDetails->toArray();

      $this->assertEquals('2014-01-01 00:00:00', $bookingDetailsData['fromDate']);
      $this->assertEquals('2014-01-10 00:00:00', $bookingDetailsData['toDate']);
      $this->assertEquals('Elin', $bookingDetailsData['rentalObjectOwnerName']);
      $this->assertEquals('Speedhuswagn', $bookingDetailsData['rentalObjectName']);
   }
} 
