/**
 * Created by Elin on 2014-06-12.
 */
(function () {
   angular.module('Rentatool').controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', 'User', 'NavigationService', 'UserService', 'PaginationService', function ($scope, $location, RentalObject, User, NavigationService, UserService, PaginationService) {
      var GETParameters;

      $scope.getRentalObjects = function () {
         GETParameters = $scope.rentalObjectFilter;
         GETParameters.page = $scope.pagination.page;
         GETParameters.entryLimit = $scope.pagination.entryLimit;
         $scope.rentalObjectCollection = RentalObject.query(GETParameters);
      };

      PaginationService.setPagination($scope, $scope.getRentalObjects);

      $scope.searchRentalObject = function () {
         $scope.setPage(1);
      };

      $scope.rentalObjectFilter = {};
      $scope.rentalObjectCollection = $scope.getRentalObjects();

      if (UserService.isLoggedIn()) {
         $scope.currentUser = UserService.getCurrentUser();
      }

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