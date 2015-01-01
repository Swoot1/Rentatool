/**
 * Created by elinnilsson on 16/08/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('RentObjectController', ['$scope', '$routeParams', '$location', 'RentalObject', 'RentPeriod', 'RentPeriodCalculator', function ($scope, $routeParams, $location, RentalObject, RentPeriod, RentPeriodCalculator) {
         $scope.rentalObject = RentalObject.get({id: $routeParams.id});
         $scope.rentPeriod = new RentPeriod({});
         $scope.rentPeriod.rentalObjectId = parseInt($routeParams.id, 10);

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
            var rentPeriodCalculator = new RentPeriodCalculator($scope.rentPeriod);
            rentPeriodCalculator.$save(function (data) {
               $scope.rentPeriod.price = data.price;
            });
         };

         $scope.createRentPeriod = function () {
            $scope.rentPeriod.$save({}, function (data) {
               $location.path('/rentperiodconfirmations/' + data.id);
            });
         };

         $scope.returnToRentalObjectList = function () {
            $location.path('/rentalobjects');
         };
      }]);
})();