/**
 * Created by Elin on 2014-06-12.
 */
(function () {
   angular.module('Rentatool').controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', 'User', 'NavigationService', 'UserService', function ($scope, $location, RentalObject, User, NavigationService, UserService) {
      $scope.rentalObjectCollection = RentalObject.query();
      $scope.rentalObjectFilter = {};

       if (UserService.isLoggedIn()) {
           $scope.currentUser = UserService.getCurrentUser();
       }

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

      $scope.getThumbNailURL = function (rentalObject) {
         var url = '', id, extension;

         if (rentalObject.fileCollection.length > 0) {
            id = rentalObject.fileCollection[0].id;
            extension = rentalObject.fileCollection[0].fileExtension;
            url = 'Public/RentalObjectPhotos/' + id + '.' + extension;
         }

         return url;
      };

       $scope.navigateToRentalObject = NavigationService.navigateToRentalObject;
   }]);
})();