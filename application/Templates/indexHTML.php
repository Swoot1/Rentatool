<?php

namespace Rentatool\Application\Templates;

echo '<!DOCTYPE html>
<html ng-app="Rentatool">
<head>
    <title>Rentatool</title>
    <meta charset="utf-8"/>
    <link href="Public/css/Foundation/css/foundation.css" type="text/css" rel="stylesheet"/>
    <link href="Public/test.css" type="text/css" rel="stylesheet"/>
    <base href="/rentatool/" />
</head>
<body>
<div id="content">
    <div ng-controller="AuthorizationController">
        <span logoutbutton></span>
    </div>
    <div class="row">
       <div class="12-columns large">
         <span alertbox></span>
       </div>
    </div>
    <div ng-controller="NavigationController">
        <ul>
            <li ng-click="navigateToLogIn()">Inloggningssida</li>
            <li ng-click="navigateToUserList()">Användare</li>
            <li ng-click="navigateToRentalObjectList()">Uthyrningsobjekt</li>
            <li ng-click="navigateToCreateDatabase()">Databasskapning</li>
        </ul>
    </div>
    <div ng-view>
    </div>
</div>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-route.js"></script>
<script type="text/javascript" src="Public/Scripts/app.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/AlertBox.js"></script>
<script type="text/javascript" src="Public/Scripts/Services/AlertBoxService.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/Focus.js"></script>
<script type="text/javascript" src="Public/Scripts/Filters.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RentalObjectFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/DatabaseFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/AuthorizationFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/DatabaseController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/RentalObjectListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/NavigationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/AuthorizationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/LogOutButton.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestErrorInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestSuccessInterceptorFactory.js"></script>
</body>
</html>';