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

      return paginationService;
   }]);
})();