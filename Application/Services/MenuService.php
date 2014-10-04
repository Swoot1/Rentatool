<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:28
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Services;


use Application\Collections\MenuItemCollection;
use Application\ENFramework\AccessRules\AdministrativeAccessRule;
use Application\ENFramework\AccessRules\AuthorizedAccessRule;
use Application\ENFramework\Helpers\SessionManager;

class MenuService{
   private $menuItems;

   public function __construct(){
      $this->menuItems = [
         ['label' => 'Användare', 'callback' => 'navigateToUserList', 'accessRule' => new AdministrativeAccessRule()],
         ['label' => 'Uthyrningsobjekt', 'callback' => 'navigateToRentalObjectList'],
         ['label' => 'Databasskapning', 'callback' => 'navigateToCreateDatabase', 'accessRule' => new AuthorizedAccessRule()]
      ];
   }

   public function getMenuItems(){
      $menuItems      = [];
      $isUserLoggedIn = SessionManager::isUserLoggedIn();

      foreach ($this->menuItems as $menuItem){
         if (array_key_exists('accessRule', $menuItem)){
            if (!$isUserLoggedIn){
               continue;
            }

            if (!$menuItem['accessRule']->isAccessAllowed(SessionManager::getCurrentUser())){
               continue;
            }
         }

         array_push($menuItems, $menuItem);
      }

      return new MenuItemCollection($menuItems);
   }
}
