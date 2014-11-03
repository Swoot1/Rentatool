/**
 * Created by elinnilsson on 02/11/14.
 */
(function () {
   angular.module('Rentatool').controller('SignUpController', ['SignUp', '$scope', function (SignUp, $scope) {

      $scope.signUp = new SignUp({});

      $scope.createSignUp = function () {
         $scope.signUp.$save({});
      };

   }]);
})();