/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', function ($scope, $location, RentalObject) {
   $scope.rentalObjectCollection = RentalObject.query();
   $scope.rentalObjectFilter = {};

   $scope.searchRentalObject = function (rentalObjectFilter) {
      var GETParams = {};
      var isDateRegex = /^\d\d\d\d-\d\d-\d\d$/;

      $scope.rentalObjectFilter.fromDate = isDateRegex.test($scope.rentalObjectFilter.fromDate) ? $scope.rentalObjectFilter.fromDate + ' 00:00:00' : $scope.rentalObjectFilter.fromDate; // TODO ugly
      $scope.rentalObjectFilter.toDate = isDateRegex.test($scope.rentalObjectFilter.toDate) ? $scope.rentalObjectFilter.toDate + ' 00:00:00' : $scope.rentalObjectFilter.toDate;

      for (var i in rentalObjectFilter) {
         if (rentalObjectFilter.hasOwnProperty(i) && rentalObjectFilter[i]) {
            GETParams[i] = rentalObjectFilter[i];
         }
      }

      $scope.rentalObjectCollection = RentalObject.query(
         GETParams);
   };

   $scope.navigateToCreateNewRentalObject = function () {
      $location.path('/rentalobjects/new');
   };

   $scope.navigateToRentRentalObject = function (rentalObject) {
      $location.path('/rentobjects/' + rentalObject.id);
   };

   $scope.editRentalObject = function (rentalObject) {
      $location.path('/rentalobjects/' + rentalObject.id);
   };

   $scope.deleteRentalObject = function (rentalObject) {
      var indexOfRentalObject;
      var rentalObjectResource = new RentalObject(rentalObject);

      rentalObjectResource.$delete({id: rentalObjectResource.id},
         function () {
            indexOfRentalObject = $scope.rentalObjectCollection.indexOf(rentalObject);
            $scope.rentalObjectCollection.splice(indexOfRentalObject, 1);
         });
   };
}]);