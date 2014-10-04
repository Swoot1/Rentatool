<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-04
 * Time: 15:23
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\ServiceTests;


use Application\Services\MenuService;

class MenuServiceTest extends \PHPUnit_Framework_TestCase{

   /**
    * @var MenuService
    */
   private $menuService;


   public function setUp(){
      $this->menuService = new MenuService();
   }

   public function tearDown() {
      unset($_SESSION);
   }

   public function testReturnsCollection(){
      $menuItems = $this->menuService->getMenuItems();
      $this->assertInstanceOf('Application\ENFramework\Collections\GeneralCollection', $menuItems);
   }

   public function testGetPublicMenu(){
      $expectedMenuItems = ['Uthyrningsobjekt'];
      $menuItems         = $this->menuService->getMenuItems()->toArray();

      $this->assertMenuIsSame($expectedMenuItems, $menuItems);
   }

   public function testGetAuthorizedMenu(){
      $_SESSION['user']  = ['id' => 1, 'username' => 'test'];

      $expectedMenuItems = ['Uthyrningsobjekt', 'Databasskapning'];
      $menuItems         = $this->menuService->getMenuItems()->toArray();

      $this->assertMenuIsSame($expectedMenuItems, $menuItems);
   }

   public function testGetAdministratorMenu(){
      $_SESSION['user']  = ['id' => 1, 'username' => 'testadministrator', 'hasAdministrativeAccess' => true];

      $expectedMenuItems = ['Uthyrningsobjekt', 'Databasskapning', 'Användare'];
      $menuItems         = $this->menuService->getMenuItems()->toArray();

      $this->assertMenuIsSame($expectedMenuItems, $menuItems);
   }

   /**
    * Compare menu item count and names
    *
    * @param $expectedItems
    * @param $actualItems
    */
   private function assertMenuIsSame($expectedItems, $actualItems){
      $this->assertEquals(count($expectedItems), count($actualItems));

      foreach ($actualItems as $actualItem){
         $this->assertContains($actualItem['label'], $expectedItems);
      }
   }

}
