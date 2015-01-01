<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 17:14
 */

namespace Tests\FactoryTests;


use Application\Factories\RentPeriodConfirmationFactory;
use Application\Models\RentalObject;
use Application\Models\RentPeriod;
use Application\Models\User;

class RentPeriodConfirmationFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testGetRentPeriodConfirmation(){
      $rentPeriodConfirmationFactory = new RentPeriodConfirmationFactory();

      $rentPeriod        = new RentPeriod(array('fromDate' => '2014-01-01', 'toDate' => '2014-01-10', 'pricePerDay' => 20));
      $rentalObjectOwner = new User(array('username' => 'Elin'));
      $rentalObject      = new RentalObject(array('name' => 'Speedhuswagn'));

      $rentPeriodConfirmation = $rentPeriodConfirmationFactory->getRentPeriodConfirmation($rentPeriod, $rentalObjectOwner, $rentalObject);

      $rentPeriodConfirmationData = $rentPeriodConfirmation->toArray();

      $this->assertEquals('2014-01-01 00:00:00', $rentPeriodConfirmationData['fromDate']);
      $this->assertEquals('2014-01-10 00:00:00', $rentPeriodConfirmationData['toDate']);
      $this->assertEquals('Elin', $rentPeriodConfirmationData['rentalObjectOwnerName']);
      $this->assertEquals('Speedhuswagn', $rentPeriodConfirmationData['rentalObjectName']);
   }
} 
