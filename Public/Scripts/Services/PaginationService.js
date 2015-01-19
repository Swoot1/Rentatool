/**
 * Created by Elin on 2014-07-31.
 */
(function () {
   angular.module('Rentatool').factory('PaginationService', ['$rootScope', function ($rootScope) {
      var paginationService = {};


      $rootScope.totalNumberOfRows = null;

      paginationService.setTotalRowsForPagination = function (totalNumberOfRows) {
         $rootScope.totalNumberOfRows = totalNumberOfRows;
      };

      paginationService.setPagination = function (scope, getIndexFunction) {
         scope.pagination = {
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

         scope.$watchGroup(['pagination.page', 'pagination.numberOfPages'], function () {
            var pageNumber = scope.pagination.page, k = 0;
            var diff = scope.pagination.numberOfPages - scope.pagination.page;
            var i = diff === 0 ? -2 : (diff === 1 ? -1 : 0);

            scope.pagination.pages = [];

            while (pageNumber > 1 && i < 2) {
               pageNumber--;
               i++;
            }

            while (k < 5 && pageNumber <= scope.pagination.numberOfPages) {
               scope.pagination.pages.push(pageNumber);
               pageNumber++;
               k++;
            }
         });

         scope.$watch('totalNumberOfRows', function () {
            scope.pagination.numberOfPages = Math.ceil(scope.totalNumberOfRows / scope.pagination.entryLimit);
         });

         scope.$watch('pagination.page', function (newValue) {
            scope.setPage(newValue);
         });

         scope.setPage = function (page) {
            scope.pagination.page = page;
            getIndexFunction();
         };
      };

      return paginationService;
   }]);
})();