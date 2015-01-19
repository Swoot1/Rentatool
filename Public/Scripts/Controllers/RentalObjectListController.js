/**
 * Created by Elin on 2014-06-12.
 */
(function () {
   angular.module('Rentatool').controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', 'User', 'NavigationService', 'UserService', function ($scope, $location, RentalObject, User, NavigationService, UserService) {

      $scope.pagination = {
         page: 1,
         entryLimit: 3,
         numberOfPages: 1,
         goToFirstPage: function () {
            this.page = 1;
         },
         goToPreviousPage: function () {
            this.page--;
         },
         goToNextPage: function () {
            this.page++;
         },
         goToLastPage: function () {
            this.page = this.numberOfPages;
         },
         pages: [1]
      };

      $scope.$watchGroup(['pagination.page', 'pagination.numberOfPages'], function () {
         var pageNumber = $scope.pagination.page, k = 0;
         var diff = $scope.pagination.numberOfPages - $scope.pagination.page;
         var i = diff === 0 ? -2 : (diff === 1 ? -1 : 0);

         $scope.pagination.pages = [];

         while (pageNumber > 1 && i < 2) {
            pageNumber--;
            i++;
         }

         while (k < 5 && pageNumber <= $scope.pagination.numberOfPages) {
            $scope.pagination.pages.push(pageNumber);
            pageNumber++;
            k++;
         }
      });

      $scope.$watch('totalNumberOfRows', function () {
         $scope.pagination.numberOfPages = Math.ceil($scope.totalNumberOfRows / $scope.pagination.entryLimit);
      });

      $scope.$watch('pagination.page', function (newValue) {
         $scope.setPage(newValue);
      });

      $scope.setPage = function (page) {
         $scope.pagination.page = page;
         $scope.getRentalObjects();
      };

      $scope.getRentalObjects = function () {
         var GETParameters = $scope.rentalObjectFilter;
         GETParameters.page = $scope.pagination.page;
         GETParameters.entryLimit = $scope.pagination.entryLimit;
         $scope.rentalObjectCollection = RentalObject.query(GETParameters);
      };

      $scope.searchRentalObject = function () {
         $scope.pagination.page = 1;
         $scope.getRentalObjects();
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