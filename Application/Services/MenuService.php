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
use Application\PHPFramework\AccessRules\AdministrativeAccessRule;
use Application\PHPFramework\AccessRules\AuthorizedAccessRule;
use Application\PHPFramework\SessionManager;

class MenuService{
   private $menuItems;
   private $sessionManager;

   public function __construct(SessionManager $sessionManager){
      $this->sessionManager = $sessionManager;
      $this->menuItems      = [
         ['label' => 'Användare', 'callback' => 'navigateToUserList', 'accessRule' => new AdministrativeAccessRule()],
         ['label' => 'Uthyrningsobjekt', 'callback' => 'navigateToRentalObjectList'],
         ['label' => 'Mina Bokningar', 'callback' => 'navigateToMyBookingList', 'accessRule' => new AuthorizedAccessRule()],
         ['label' => 'Mina Uthyrningsobjekt', 'callback' => 'navigateToMyRentalObjectsList', 'accessRule' => new AuthorizedAccessRule()],
         ['label' => 'Databasskapning', 'callback' => 'navigateToCreateDatabase', 'accessRule' => new AuthorizedAccessRule()]
      ];
   }

   public function index(){
      $menuItems      = [];
      $isUserLoggedIn = $this->sessionManager->isUserLoggedIn();

      foreach ($this->menuItems as $menuItem){
         if (array_key_exists('accessRule', $menuItem)){
            if (!$isUserLoggedIn){
               continue;
            }

            if (!$menuItem['accessRule']->isAccessAllowed($this->sessionManager->getCurrentUser())){
               continue;
            }
         }

         array_push($menuItems, $menuItem);
      }

      return new MenuItemCollection($menuItems);
   }
}
