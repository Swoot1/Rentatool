/**
 * Created by Elin on 2014-04-18.
 */

(function () {
   angular.module('Rentatool').controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'RentalObjectService', function ($scope, $routeParams, RentalObject, $location, RentalObjectService) {

      if ($routeParams.id) {
         $scope.rentalObject = RentalObject.get({id: $routeParams.id});
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