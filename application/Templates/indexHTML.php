<?php

namespace Rentatool\Application\Templates;

echo '<!DOCTYPE html>
<html ng-app="Rentatool">
<head>
    <title>Ojas fiskeri</title>
    <meta charset="utf-8"/>
    <link href="Public/Foundation/css/foundation.css" type="text/css" rel="stylesheet"/>
    <link href="Public/test.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="content">
    <div ng-controller="AuthorizationController">
        <span logoutbutton>Should be a button</span>
    </div>
    <div ng-controller="NavigationController">
        <ul>
            <li ng-click="navigateToUserList()">Användare</li>
            <li ng-click="navigateToFishList()">Fiskar</li>
            <li ng-click="navigateToCaughtFishList()">Fångade fiskar</li>
        </ul>
    </div>
    <div ng-view>
    </div>
</div>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-route.js"></script>
<script type="text/javascript" src="Public/Scripts/app.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/EnsureUniqueFish.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/Focus.js"></script>
<script type="text/javascript" src="Public/Scripts/Filters.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/FishFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/CaughtFishFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/UserFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/AuthorizationFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Factories/RequestErrorInterceptorFactory.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/FishController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/CaughtFishController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/NavigationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/UserListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/CaughtFishListController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/AuthorizationController.js"></script>
<script type="text/javascript" src="Public/Scripts/Controllers/MenuController.js"></script>
<script type="text/javascript" src="Public/Scripts/Directives/LogOutButton.js"></script>
</body>
</html>';