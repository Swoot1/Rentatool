/**
 * Created by Elin on 2014-05-26.
 */

var goFish = angular.module('GoFish', ['ngResource', 'filters', 'ngRoute'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/fish/new', {
                templateUrl: 'application/public/Templates/fish.html',
                controller: 'FishController'
            })
            .when('/caughtfish/new', {
                templateUrl: 'application/public/Templates/caughtfish.html',
                controller: 'CaughtFishController'
            })
            .when('/user/new', {
                templateUrl: 'application/public/Templates/user.html',
                controller: 'UserController'
            })
            .when('/user/:id', {
                templateUrl: 'application/public/Templates/user.html',
                controller: 'UserController'
            })
            .when('/user', {
                templateUrl: 'application/public/Templates/userlist.html',
                controller: 'UserListController'
            })
            .when('/login', {
                templateUrl: 'application/public/Templates/login.html',
                controller: 'LoginController'
            })
            .otherwise({
                redirectTo: '/login'
            });
    }]);