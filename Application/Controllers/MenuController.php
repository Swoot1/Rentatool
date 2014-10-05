<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 16:57
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\MenuService;

class MenuController{

   private $response;

   public function __construct(ResponseFactory $responseFactory, MenuService $menuService){
      $this->response = $responseFactory->build();
      $this->menuService = $menuService;
   }

   public function index(){
      $menuItems = $this->menuService->index();

      $this->response->setResponseData($menuItems);

      return $this->response;
   }

}
