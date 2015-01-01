<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 13/08/14
 * Time: 16:16
 */

namespace Tests\ENFrameworkTests\DependencyInjectionTests;

use Application\Factories\MailFactory;
use Application\PHPFramework\Configurations\MailConfiguration;
use Application\PHPFramework\DependencyInjection\DependencyInjection;
use Application\PHPFramework\SessionManager;

class DependencyInjectionTest extends \PHPUnit_Framework_TestCase{

   public function testGetController(){
      // TODO for a person with patience why is get_include_path() necessary?
      $dependencyInjectionContainer = simplexml_load_file(get_include_path() . 'Application/PHPFramework/DependencyInjection/DependencyInjectionContainer.xml');
      $requestMock                  = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                                           ->disableOriginalConstructor()
                                           ->getMock();

      $dependencyInjection = new DependencyInjection($dependencyInjectionContainer);
      $sessionManager      = new SessionManager();
      $dependencyInjection->setInstantiatedClasses(array('Request'        => $requestMock,
                                                         'SessionManager' => $sessionManager));
      $userController = $dependencyInjection->getInstantiatedClass('UserController');

      $this->assertTrue(get_class($userController) === 'Application\Controllers\UserController');
   }

   public function testControllerWithRequest(){
      // TODO for a person with patience why is get_include_path() necessary?
      $dependencyInjectionContainer = simplexml_load_file(get_include_path() . 'Application/PHPFramework/DependencyInjection/DependencyInjectionContainer.xml');
      $requestMock                  = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                                           ->disableOriginalConstructor()
                                           ->getMock();

      $dependencyInjection = new DependencyInjection($dependencyInjectionContainer);
      $sessionManager      = new SessionManager();
      $dependencyInjection->setInstantiatedClasses(array('Request'        => $requestMock,
                                                         'SessionManager' => $sessionManager));
      $rentalObjectController = $dependencyInjection->getInstantiatedClass('RentalObjectController');

      $this->assertTrue(get_class($rentalObjectController) === 'Application\Controllers\RentalObjectController');
   }

   public function testControllerWithSessionManager(){
      // TODO for a person with patience why is get_include_path() necessary?
      $dependencyInjectionContainer = simplexml_load_file(get_include_path() . 'Application/PHPFramework/DependencyInjection/DependencyInjectionContainer.xml');
      $requestMock                  = $this->getMockBuilder('Application\PHPFramework\Request\Request')
                                           ->disableOriginalConstructor()
                                           ->getMock();

      $dependencyInjection = new DependencyInjection($dependencyInjectionContainer);
      $sessionManager      = new SessionManager();
      $mailFactory         = new MailFactory(new \PHPMailer(), new MailConfiguration());
      $dependencyInjection->setInstantiatedClasses(array('Request'        => $requestMock,
                                                         'SessionManager' => $sessionManager,
                                                         'MailFactory'    => $mailFactory));


      $rentPeriodController = $dependencyInjection->getInstantiatedClass('RentPeriodController');

      $this->assertTrue(get_class($rentPeriodController) === 'Application\Controllers\RentPeriodController');
   }
} 
