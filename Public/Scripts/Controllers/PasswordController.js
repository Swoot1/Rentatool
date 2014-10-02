/**
 * Created by elinnilsson on 01/10/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('PasswordController', ['$scope', 'Password', '$location', function ($scope, Password, $location) {
         $scope.password = new Password();
         $scope.password.resetCode = $location.search().resetCode;

         $scope.createPassword = function () {
            $scope.password.$save();
         };
      }]);
})();