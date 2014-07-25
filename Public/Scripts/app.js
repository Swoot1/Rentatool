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
            .when('/rentalobjects', {
                templateUrl: 'public/Templates/rentalObjectList.html',
                controller: 'RentalObjectListController'
            })
            .when('/rentalobjects/:id', {
                templateUrl: 'public/Templates/rentalObjectUpdate.html',
                controller: 'RentalObjectController'
            })
            .when('/users/new', {
                templateUrl: 'public/Templates/userCreate.html',
                controller: 'UserController'
            })
            .when('/users/:id', {
                templateUrl: 'public/Templates/userUpdate.html',
                controller: 'UserController'
            })
            .when('/users', {
                templateUrl: 'public/Templates/userList.html',
                controller: 'UserListController'
            })
            .when('/authorization/login', {
                templateUrl: 'public/Templates/login.html',
                controller: 'AuthorizationController'
            })
            .when('/databases/new', {
                templateUrl: 'public/Templates/database.html',
                controller: 'DatabaseController'
            })
            .otherwise({
                redirectTo: '/authorization/login'
            });

        $httpProvider.interceptors.push('requestErrorInterceptor');
    }]);
