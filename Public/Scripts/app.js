/**
 * Created by Elin on 2014-05-26.
 */

var rentaTool = angular.module('Rentatool', ['ngResource', 'filters', 'ngRoute', 'blueimp.fileupload'])
   .config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
      $routeProvider
         .when('/rentalobjects/new', {
            templateUrl: 'Public/Templates/rentalObject.html',
            controller: 'RentalObjectController'
         })
         .when('/rentalobjects', {
            templateUrl: 'Public/Templates/rentalObjectList.html',
            controller: 'RentalObjectListController'
         })
         .when('/rentalobjects/:id', {
            templateUrl: 'Public/Templates/rentalObjectUpdate.html',
            controller: 'RentalObjectController'
         })
         .when('/users/new', {
            templateUrl: 'Public/Templates/userCreate.html',
            controller: 'UserController'
         })
         .when('/users/:id', {
            templateUrl: 'Public/Templates/userUpdate.html',
            controller: 'UserController'
         })
         .when('/users', {
            templateUrl: 'Public/Templates/userList.html',
            controller: 'UserListController'
         })
         .when('/authorization/login', {
            templateUrl: 'Public/Templates/login.html',
            controller: 'AuthorizationController'
         })
         .when('/databases/new', {
            templateUrl: 'Public/Templates/database.html',
            controller: 'DatabaseController'
         })
         .when('/rentobjects/:id', {
            templateUrl: 'Public/Templates/rentObjectCreate.html',
            controller: 'RentObjectController'
         })
         .when('/resetpasswords/new', {
            templateUrl: 'Public/Templates/resetPassword.html',
            controller: 'ResetPasswordController'
         })
         .when('/passwords/new', {
            templateUrl: 'Public/Templates/passwordCreate.html',
            controller: 'PasswordController'
         })
         .otherwise({
            redirectTo: '/rentalobjects'
         });

      $httpProvider.interceptors.push('RequestErrorInterceptor');
      $httpProvider.interceptors.push('RequestSuccessInterceptor');
   }]);
