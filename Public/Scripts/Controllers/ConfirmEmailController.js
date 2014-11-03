/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('ConfirmEmailController', ['$routeParams', 'User', '$scope', function ($routeParams, User, $scope) {

      $scope.confirmation = {};
      User.get({id: 'confirmemail', email: $routeParams.email}, function(data){
         $scope.confirmation = data;
      });

   }]);
})();