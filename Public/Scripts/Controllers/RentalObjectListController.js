/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', function ($scope, $location, RentalObject) {
   $scope.rentalObjectCollection = RentalObject.query();
   $scope.rentalObjectFilter = {};

   $scope.searchRentalObject = function (rentalObjectFilter) {
      $scope.rentalObjectCollection = RentalObject.query({'query': rentalObjectFilter.query});
   };

   $scope.navigateToCreateNewRentalObject = function () {
      $location.path('/rentalobjects/new');
   };

   $scope.navigateToRentRentalObject = function(rentalObject){
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