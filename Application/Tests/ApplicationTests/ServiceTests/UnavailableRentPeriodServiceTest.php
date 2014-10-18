<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 18/10/14
 * Time: 19:34
 */

namespace Tests\ServiceTests;


use Application\Services\UnavailableRentPeriodService;

class UnavailableRentPeriodServiceTest extends \PHPUnit_Framework_TestCase{
   public function testIndex(){
      $unavailableRentPeriodMapperMock = $this->getMockBuilder('Application\Mappers\UnavailableRentPeriodMapper')
                                              ->disableOriginalConstructor()
                                              ->getMock();
      $unavailableRentPeriodMapperMock->expects($this->once())
                                      ->method('index')
                                      ->will($this->returnValue(array()));

      $unavailableRentPeriodService = new UnavailableRentPeriodService($unavailableRentPeriodMapperMock);


      $unavailableRentPeriodFilterMock = $this->getMockBuilder('Application\Filters\UnavailableRentPeriodFilter')
                                              ->disableOriginalConstructor()
                                              ->getMock();

      $unavailableRentPeriodCollection = $unavailableRentPeriodService->index($unavailableRentPeriodFilterMock);

      $this->assertInstanceOf('Application\Collections\UnavailableRentPeriodCollection', $unavailableRentPeriodCollection);
   }
} 