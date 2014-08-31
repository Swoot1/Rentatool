<?php

namespace Rentatool\Application\Templates;

echo '<!DOCTYPE html>
<html ng-app="Rentatool">
<head>
    <title>Rentatool</title>
    <meta charset="utf-8"/>
    <link href="Public/css/normalize.css" type="text/css" rel="stylesheet"/>
    <link href="Public/css/Foundation/css/foundation.css" type="text/css" rel="stylesheet"/>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link href="Public/test.css" type="text/css" rel="stylesheet"/>
    <base href="/rentatool/" />
</head>
<body>
<div id="content">
   <nav class="top-bar" data-topbar ng-controller="NavigationController">
     <ul class="title-area">
       <li class="name">
         <h1><a href="#">Rentatool</a></h1>
       </li>
        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
       <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
     </ul>

     <section class="top-bar-section">
       <!-- Right Nav Section -->
       <ul class="right">
        <div ng-controller="AuthorizationController">
        <span logoutbutton></span>
        </div>
       </ul>

       <!-- Left Nav Section -->
       <ul class="left">
         <li ng-click="navigateToLogIn()"><a>Inloggningssida</a></li>
         <li ng-click="navigateToUserList()"><a>Användare</a></li>
         <li ng-click="navigateToUserGroupList()"><a>Användargrupper</a></li>
         <li ng-click="navigateToRentalObjectList()"><a>Uthyrningsobjekt</a></li>
         <li ng-click="navigateToCreateDatabase()"><a>Databasskapning</a></li>
       </ul>
     </section>
   </nav>
    <div class="row">
       <div class="12-columns large">
         <span alertbox></span>
       </div>
    </div>
    <div ng-view>
    </div>
</div>
<script type="text/javascript" src="Public/css/Foundation/js/vendor/modernizr.js"></script>
<script type="text/javascript" src="Public/css/Foundation/js/vendor/fastclick.js"></script>
<script type="text/javascript" src="Public/css/Foundation/js/vendor/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-route.js"></script>
<script type="text/javascript" src="Public/Scripts/app.js"></script>
<script type="text/javascript" src="Public/Scripts/Filters/TimeUnitFilter.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/AlertBox.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/AlertBoxService.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/Datepicker.js"></script>
<script type="text/javascript" src="Public/Scripts/Filters.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentalObjectFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentPeriodFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentPeriodCalculatorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/PricePlanFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/TimeUnitFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/DatabaseFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/AuthorizationFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserGroupFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/DatabaseController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentObjectController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/NavigationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/AuthorizationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserGroupListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserGroupController.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/LogOutButton.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestErrorInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestSuccessInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserGroupConnectionFactory.js"></script>
</body>
</html>';