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
<script type="text/javascript" src="Public/css/Foundation/js/vendor/modernizr.js"></script>
<script type="text/javascript" src="Public/css/Foundation/js/vendor/fastclick.js"></script>
<script type="text/javascript" src="Public/css/Foundation/js/vendor/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload-process.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-route.js"></script>
<script type="text/javascript" src="Public/Scripts/jquery.fileupload-angular.js"></script>
<script type="text/javascript" src="Public/Scripts/app.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/AlertBox.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/AlertBoxService.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/AuthorizationService.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/NavigationService.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/Datepicker.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/RentPeriodDatePicker.js"></script>
<script type="text/javascript" src="Public/Scripts/Filters.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentalObjectFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentPeriodFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentPeriodCalculatorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/SignUpFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/DatabaseFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/AuthorizationFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UnavailableRentPeriodFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestErrorInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestSuccessInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/ResetPasswordFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/PasswordFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/UnavailableRentPeriodService.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/RentalObjectService.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectPhotoController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/DatabaseController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/SignUpController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentObjectController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/NavigationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/AuthorizationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/ContentController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/ResetPasswordController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/PasswordController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/ConfirmEmailController.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/LogoutButton.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/LoginButton.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/MenuItemsFactory.js"></script>
</body>
</html>'));
   }
}
