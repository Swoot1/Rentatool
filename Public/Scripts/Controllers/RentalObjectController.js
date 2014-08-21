/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'TimeUnit', 'PricePlan', function ($scope, $routeParams, RentalObject, $location, TimeUnit, PricePlan) {

   if ($routeParams.id) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
   } else {
      $scope.rentalObject = new RentalObject({});
      $scope.rentalObject.available = true;
   }

   $scope.timeUnitCollection = TimeUnit.query();
   $scope.rentalObject.pricePlanCollection = [];

   $scope.deletePricePlan = function(pricePlan){
      var indexOfPricePlan = $scope.rentalObject.pricePlanCollection.indexOf(pricePlan);
      $scope.rentalObject.pricePlanCollection.splice(indexOfPricePlan, 1);
   };

   $scope.addPricePlan = function (pricePlan) {
      pricePlan.price = parseFloat(pricePlan.price);
      pricePlan.timeUnitId = parseInt(pricePlan.timeUnitId, 10);
      $scope.rentalObject.pricePlanCollection.push(pricePlan);
      $scope.newPricePlan = {};
   };

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