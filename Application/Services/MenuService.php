<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:28
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Services;


use Rentatool\Application\Collections\MenuItemCollection;
use Rentatool\Application\ENFramework\Helpers\AccessRules\AdministrativeAccessRule;
use Rentatool\Application\ENFramework\Helpers\AccessRules\AuthorizedAccessRule;
use Rentatool\Application\ENFramework\Helpers\SessionManager;

class MenuService {
   private $menuItems;

   public function __construct(){
      $this->menuItems = [
         ['label' => 'Inloggningssida', 'callback' => 'navigateToLogIn'],
         ['label' => 'Användare', 'callback' => 'navigateToUserList', 'accessRule' => new AdministrativeAccessRule()],
         ['label' => 'Användargrupper', 'callback' => 'navigateToUserGroupList', 'accessRule' => new AdministrativeAccessRule()],
         ['label' => 'Uthyrningsobjekt', 'callback' => 'navigateToRentalObjectList', 'accessRule' => new AuthorizedAccessRule()],
         ['label' => 'Databasskapning', 'callback' => 'navigateToCreateDatabase']
      ];
   }

   public function getMenuItems(){
      $menuItems = [];
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
