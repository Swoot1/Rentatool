<?php

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Models\IndexHTML;

class IndexHTMLController{
   private $response;

   public function __construct(ResponseFactory $responseFactory){
      $this->response = $responseFactory->build();
   }

   public function index(){
      return $this->response
         ->setContentType('text/html')
         ->setResponseData($this->getData());
   }

   private function getData(){
      return new IndexHTML(array('content' => '<!DOCTYPE html>
<html ng-app="Rentatool" class="background-image">
<head>
    <title>Hyrdet</title>
    <meta charset="utf-8"/>
    <link href="Public/css/normalize.css" type="text/css" rel="stylesheet"/>
    <link href="Public/css/Foundation/css/foundation.css" type="text/css" rel="stylesheet"/>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link href="Public/css/custom.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="content">
   <nav class="top-bar" data-topbar ng-controller="NavigationController">
     <ul class="title-area">
       <li class="name">
         <h1><a href="#">Hyrdet</a></h1>
       </li>
        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
       <li class="toggle-topbar menu-icon"><a href="#"><span>Meny</span></a></li>
     </ul>

     <section class="top-bar-section">
       <!-- Right Nav Section -->
       <ul class="right">
        <div ng-controller="AuthorizationController">
        <span logoutbutton></span>
        <span loginbutton></span>
        </div>
       </ul>

       <!-- Left Nav Section -->
       <ul class="left" ng-show="menuLoaded" ng-repeat="menuItem in menuItems">
        <li ng-click="navigate(menuItem)"><a ng-bind="menuItem.label"></a></li>
       </ul>
     </section>
   </nav>
    <div class="row">
       <div class="12-columns large">
         <span alertbox></span>
       </div>
    </div>
    <div ng-class="{row:\'enabled\', container : content.setContainerClass}" ng-controller="ContentController">
        <div class="large-12 columns" ng-view>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="dist/Rentatool.js"></script>
</body>
</html>'));
   }
}
