/**
 * Created by Elin on 2014-06-17.
 */
rentaTool.controller("AuthorizationController", ['$scope', '$location', 'Authorization', 'AlertBoxService', '$rootScope',
   'AuthorizationService', 'NavigationService',
   function ($scope, $location, Authorization, alertBoxService, $rootScope, authorizationService, navigationService) {
      var authorizationResource;

      $scope.attemptLogin = function () {
         authorizationResource = new Authorization($scope.login);
         authorizationResource.$save({action: 'login'}, function (data) {
            if (data.isLoggedIn) {
               $location.path('/rentalobjects/new');
                $rootScope.$broadcast('loginStateChanged');
                authorizationService.logIn();
            } else {
               alertBoxService.addAlertBox('alert', 'Misslyckad inloggning!');
            }
         });
      };

      $scope.attemptLogOut = function () {
         authorizationResource = new Authorization();
         authorizationResource.$get({action: 'logout'}, function () {
            authorizationService.logOut();
            $location.path('/rentalobjects');
            $rootScope.$broadcast('loginStateChanged');
         });
      };

      $scope.navigateToLogIn = navigationService.navigateToLogIn;
      $scope.navigateToResetPassword = navigationService.navigateToResetPassword;
   }]);