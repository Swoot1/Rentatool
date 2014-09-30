/**
 * Created by elinnilsson on 29/09/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('ResetPasswordController', ['$scope', 'ResetPassword', function ($scope, ResetPassword) {

         $scope.resetPassword = new ResetPassword({});

         $scope.createPasswordReset = function () {
            $scope.resetPassword.$save();
         };
      }]);
})();