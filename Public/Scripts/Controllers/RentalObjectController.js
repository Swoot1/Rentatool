/**
 * Created by Elin on 2014-04-18.
 */

(function () {
   angular.module('Rentatool').controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'RentalObjectService', 'User', function ($scope, $routeParams, RentalObject, $location, RentalObjectService, User) {

      if ($routeParams.id) {
         $scope.rentalObject = RentalObject.get({id: $routeParams.id});

         $scope.currentUser = {};

         if ($scope.userIsLoggedIn) {
            $scope.currentUser = User.get({'id': 'currentUser'});
         }

         $scope.isUserOwner = function () {
            return $scope.currentUser.id === $scope.rentalObject.userId
         };
      } else {
         $scope.rentalObject = new RentalObject({fileCollection: []});
      }

      $scope.createRentalObject = function () {
         $scope.rentalObject.$save({});
      };

      $scope.updateRentalObject = function () {
         $scope.rentalObject.$update({});
      };

      $scope.returnToRentalObjectList = function () {
         $location.path('/rentalobjects');
      };

      $scope.$watch(RentalObjectService.getPhoto, function (photo) {
         if (photo && photo.id) {
            $scope.rentalObject.fileCollection = [photo];
         }
      });
   }]);
})();