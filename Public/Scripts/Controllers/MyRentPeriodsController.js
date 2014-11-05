/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('MyRentPeriodsController', ['RentPeriod', '$scope', 'ConfirmRentPeriod', function (RentPeriod, $scope, ConfirmRentPeriod) {

      var indexOfRentPeriod;
      var confirmRentPeriod;

      $scope.rentalPeriodCollection = {};
      $scope.rentalPeriodCollection.unconfirmedRentPeriodCollection = [];

      $scope.confirmRentPeriod = function (rentPeriod) {
         confirmRentPeriod = new ConfirmRentPeriod({emailContent: rentPeriod.emailContent});
         confirmRentPeriod.$update({id: rentPeriod.id}, function () {
            indexOfRentPeriod = $scope.rentalPeriodCollection.unconfirmedRentPeriodCollection.indexOf(rentPeriod);
            $scope.rentalPeriodCollection.unconfirmedRentPeriodCollection.splice(indexOfRentPeriod, 1);
         });
      };

      RentPeriod.query(function (data) {
         data.forEach(function (rentPeriod) {
            if (rentPeriod.isConfirmedByOwner === false) {
               $scope.rentalPeriodCollection.unconfirmedRentPeriodCollection.push(rentPeriod);
            }
         });
      });

   }]);
})();