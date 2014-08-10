/**
 * Created by Elin on 2014-06-17.
 */
rentaTool.controller("AuthorizationController", ['$scope', '$location', 'Authorization', 'AlertBoxService',
   function ($scope, $location, Authorization, alertBoxService) {
      var authorizationResource;

      $scope.attemptLogin = function () {
         authorizationResource = new Authorization($scope.login);
         authorizationResource.$save({action: 'login'}, function (data) {
            if (data.isLoggedIn) {
               $location.path('/rentalobjects/new');
            } else {
               alertBoxService.addAlertBox('alert', 'Misslyckad inloggning!');
            }
         });
      };

      $scope.attemptLogOut = function () {
         authorizationResource = new Authorization();
         authorizationResource.$get({action: 'logout'}, function () {
            $location.path('/authorization/login');
         });
      };
   }]);