<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-12-30
 * Time: 21:32
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\ServiceTests;


use Application\Services\RentalNotificationService;

class RentalNotificationServiceTest extends \PHPUnit_Framework_TestCase{

   private $mailFactoryMock;
   private $rentalNotificationMapperMock;

   public function setUp(){
      $this->mailFactoryMock = $this->getMockBuilder('Application\Factories\MailFactory')
         ->disableOriginalConstructor()
         ->getMock();

      $this->rentalNotificationMapperMock = $this->getMockBuilder('Application\Mappers\RentalNotificationMapper')
         ->disableOriginalConstructor()
         ->getMock();

      $mailMock = $this->getMockBuilder('\PHPMailer')
         ->disableOriginalConstructor()
         ->getMock();

      $mailMock->expects($this->once())
         ->method('send')
         ->will($this->returnValue(true));

      $this->rentalNotificationMapperMock->expects($this->once())
         ->method('read')
         ->will($this->returnValue(['renterEmail' => 'x@x.x', 'rentalObjectName' => 'Husbil']));

      $this->mailFactoryMock->expects($this->once())
         ->method('build')
         ->will($this->returnValue($mailMock));
   }

   public function testCreate() {
      $rentalNotificationService = new RentalNotificationService($this->mailFactoryMock, $this->rentalNotificationMapperMock);
      $rentalNotificationService->create(1);
   }


}