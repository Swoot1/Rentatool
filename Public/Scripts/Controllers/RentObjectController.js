/**
 * Created by elinnilsson on 16/08/14.
 */
angular.module('Rentatool')
   .controller('RentObjectController', ['$scope', '$routeParams', '$location', 'RentalObject', 'RentPeriod', function ($scope, $routeParams, $location, RentalObject, RentPeriod) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
      $scope.rentPeriod = new RentPeriod({});
      $scope.rentPeriod.rentalObjectId = parseInt($routeParams.id, 10);

      $scope.createRentPeriod = function () {
         $scope.rentPeriod.$save({});
      };

      $scope.returnToRentalObjectList = function () {
         $location.path('/rentalobjects');
      };

   }]);