/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'TimeUnit', function ($scope, $routeParams, RentalObject, $location, TimeUnit) {

   if ($routeParams.id) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
   } else {
      $scope.rentalObject = new RentalObject({});
      $scope.rentalObject.available = true;
   }

   $scope.timeUnitCollection = TimeUnit.query();

   $scope.createRentalObject = function () {
      $scope.rentalObject.$save({}, function (data) {
         $scope.rentalObjectCollection.push(data);
      });
   };

   $scope.updateRentalObject = function () {
      $scope.rentalObject.$update({}, function () {
      });
   };

   $scope.returnToRentalObjectList = function () {
      $location.path('/rentalobjects');
   };
}]);