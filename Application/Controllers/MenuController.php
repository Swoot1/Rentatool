<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 16:57
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Controllers;


use Application\ENFramework\Helpers\ResponseFactory;
use Application\Services\MenuService;

class MenuController{

   private $response;

   public function __construct(ResponseFactory $responseFactory){
      $this->response = $responseFactory->createResponse();
   }

   public function index(){
      $menuService = new MenuService();
      $menuItems   = $menuService->getMenuItems();

      $this->response->setResponseData($menuItems);

      return $this->response;
   }

}
