/**
 * Created by Elin on 2014-06-16.
 */
(function () {
   angular.module('Rentatool').controller('UserController', ['$scope', '$routeParams', '$location', 'User', function ($scope, $routeParams, $location, User) {

      var createUser = function () {
         $scope.user.$save({});
      };

      var updateUser = function () {
         $scope.user.$update({});
      };

      if ($routeParams.id) {
         $scope.user = User.get({id: $routeParams.id});
         $scope.userFormConfiguration = {
            submitFunction: updateUser,
            submitButtonText: 'Uppdatera användare'
         };
      } else {
         $scope.user = new User({});
         $scope.userFormConfiguration = {
            submitFunction: createUser,
            submitButtonText: 'Skapa användare'
         };
      }

      $scope.returnToUserList = function () {
         $location.path('/users');
      };
   }]);
})();
