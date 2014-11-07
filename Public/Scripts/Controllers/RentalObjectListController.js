/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', 'User', function ($scope, $location, RentalObject, User) {
   $scope.rentalObjectCollection = RentalObject.query();
   $scope.rentalObjectFilter = {};
   $scope.currentUser = $scope.userIsLoggedIn && User.get({'id' : 'currentUser'});

   $scope.searchRentalObject = function (rentalObjectFilter) {
      var GETParams = {};

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

   $scope.navigateToRentalObject = function (rentalObject) {
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