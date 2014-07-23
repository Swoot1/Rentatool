/**
 * Created by Elin on 2014-05-26.
 */

var rentaTool = angular.module('Rentatool', ['ngResource', 'filters', 'ngRoute'])
    .config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
        $routeProvider
            .when('/rentalobjects/new', {
                templateUrl: 'public/Templates/rentalObject.html',
                controller: 'RentalObjectController'
            })
            .when('/caughtfish/new', {
                templateUrl: 'public/Templates/caughtFish.html',
                controller: 'CaughtFishController'
            })
            .when('/caughtfish', {
                templateUrl: 'public/Templates/caughtFishList.html',
                controller: 'CaughtFishListController'
            })
            .when('/user/new', {
                templateUrl: 'public/Templates/userCreate.html',
                controller: 'UserController'
            })
            .when('/user/:id', {
                templateUrl: 'public/Templates/userUpdate.html',
                controller: 'UserController'
            })
            .when('/user', {
                templateUrl: 'public/Templates/userList.html',
                controller: 'UserListController'
            })
            .when('/authorization/login', {
                templateUrl: 'public/Templates/login.html',
                controller: 'AuthorizationController'
            })
            .when('/database/new', {
                templateUrl: 'public/Templates/database.html',
                controller: 'DatabaseController'
            })
            .otherwise({
                redirectTo: '/authorization/login'
            });

        $httpProvider.interceptors.push('requestErrorInterceptor');
    }]);