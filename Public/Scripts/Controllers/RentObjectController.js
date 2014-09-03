/**
 * Created by elinnilsson on 16/08/14.
 */
angular.module('Rentatool')
   .controller('RentObjectController', ['$scope', '$routeParams', '$location', 'RentalObject', 'RentPeriod', 'TimeUnit', 'RentPeriodCalculator', function ($scope, $routeParams, $location, RentalObject, RentPeriod, TimeUnit, RentPeriodCalculator) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
      $scope.rentPeriod = new RentPeriod({});
      $scope.rentPeriod.rentalObjectId = parseInt($routeParams.id, 10);
      $scope.timeUnitCollection = TimeUnit.query();

      $scope.$watch('rentPeriod.fromDate', function (newFromDate) {
         if (newFromDate && $scope.rentPeriod.toDate) {
            $scope.calculatePrice();
         }
      });

      $scope.$watch('rentPeriod.toDate', function (newToDate) {
         if (newToDate && $scope.rentPeriod.fromDate) {
            $scope.calculatePrice();
         }
      });

      $scope.calculatePrice = function () {
         var isDateRegex = /^\d\d\d\d-\d\d-\d\d$/;
         $scope.rentPeriod.fromDate = isDateRegex.test($scope.rentPeriod.fromDate) ? $scope.rentPeriod.fromDate + ' 00:00:00' : $scope.rentPeriod.fromDate; // TODO ugly
         $scope.rentPeriod.toDate = isDateRegex.test($scope.rentPeriod.toDate) ? $scope.rentPeriod.toDate + ' 00:00:00' : $scope.rentPeriod.toDate;
         var rentPeriodCalculator = new RentPeriodCalculator($scope.rentPeriod);
         rentPeriodCalculator.$save(function (data) {
            $scope.rentPeriod.price = data.price;
         });
      };

      $scope.createRentPeriod = function () {
         $scope.rentPeriod.$save({});
      };

      $scope.returnToRentalObjectList = function () {
         $location.path('/rentalobjects');
      };

   }]);