/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'TimeUnit', 'PricePlan', function ($scope, $routeParams, RentalObject, $location, TimeUnit, PricePlan) {

   if ($routeParams.id) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
   } else {
      $scope.rentalObject = new RentalObject({});
   }

   $scope.newPricePlan = new PricePlan();

   $scope.timeUnitCollection = TimeUnit.query();
   $scope.rentalObject.pricePlanCollection = [];

   $scope.deletePricePlan = function (pricePlan) {
      var indexOfPricePlan;

      if ($scope.rentalObject.id) {
         $scope.newPricePlan.$delete({id: pricePlan.id}, function () {
            indexOfPricePlan = $scope.rentalObject.pricePlanCollection.indexOf(pricePlan);
            $scope.rentalObject.pricePlanCollection.splice(indexOfPricePlan, 1);
         });
      } else {
         indexOfPricePlan = $scope.rentalObject.pricePlanCollection.indexOf(pricePlan);
         $scope.rentalObject.pricePlanCollection.splice(indexOfPricePlan, 1);
      }
   };

   $scope.addPricePlan = function (pricePlan) {
      if ($scope.rentalObject.id) {
         $scope.newPricePlan.rentalObjectId = $scope.rentalObject.id;
         $scope.newPricePlan.$save({}, function () {
            $scope.rentalObject.pricePlanCollection.push(pricePlan);
            $scope.newPricePlan = new PricePlan();
         });
      } else {
         $scope.rentalObject.pricePlanCollection.push(pricePlan);
      }
   };

   $scope.createRentalObject = function () {
      $scope.rentalObject.$save({});
   };

   $scope.updateRentalObject = function () {
      $scope.rentalObject.$update({});
   };

   $scope.returnToRentalObjectList = function () {
      $location.path('/rentalobjects');
   };
}]);